<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;

class PosController extends Controller
{
    // Checkout: accept cart array from frontend, create sale + items, decrement product stock
    public function checkout(Request $request)
    {
        $cart = $request->input('cart');

        if (!is_array($cart) || count($cart) === 0) {
            return response()->json(['status' => 'error', 'message' => 'Cart is empty'], 422);
        }

        // Validate structure
        foreach ($cart as $c) {
            if (!isset($c['id']) || !isset($c['qty']) || !isset($c['price'])) {
                return response()->json(['status' => 'error', 'message' => 'Invalid cart data'], 422);
            }
        }

        DB::beginTransaction();
        try {
            $total = 0;
            foreach ($cart as $c) {
                $total += $c['qty'] * floatval($c['price']);
            }

            // Step 1: Create sale (without invoice_no)
            $sale = Sale::create([
                'total_amount' => $total,
            ]);

            // Step 2: Update invoice_no using ID
            $sale->invoice_no = str_pad($sale->id, 6, '0', STR_PAD_LEFT); // e.g. 000001
            $sale->save();

            // Step 3: Create sale items & decrement stock
            foreach ($cart as $c) {
                $product = Product::find($c['id']);
                if (!$product) {
                    DB::rollBack();
                    return response()->json(['status' => 'error', 'message' => 'Product not found: id ' . $c['id']], 404);
                }

                // ✅ Convert qty according to unit
                $unit = strtolower($product->unit);
                $deductQty = $c['qty']; // default

                if ($unit === 'kg') {
                    // qty from frontend is in KG → convert to grams
                    $deductQty = $c['qty'] * 1000;
                } elseif ($unit === 'litre') {
                    // qty from frontend is in Litre → convert to ml
                    $deductQty = $c['qty'] * 1000;
                }
                // piece/packet remain as is

                if ($product->stock < $deductQty) {
                    DB::rollBack();
                    return response()->json([
                        'status' => 'error',
                        'message' => "Insufficient stock for product {$product->name}"
                    ], 400);
                }

                $subtotal = $c['qty'] * floatval($c['price']);

                SaleItem::create([
                    'sale_id'   => $sale->id,
                    'product_id' => $product->id,
                    'quantity'  => $c['qty'], // save original qty (kg/litre/piece)
                    'price'     => $c['price'],
                    'subtotal'  => $subtotal,
                ]);

                // ✅ Decrement stock in smallest unit
                $product->decrement('stock', $deductQty);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Sale completed',
                'sale_id' => $sale->id,
                'invoice_no' => $sale->invoice_no
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Checkout failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Show invoice view
    public function invoice($id)
    {
        $sale = Sale::with('items.product')->findOrFail($id);
        return view('pages.pos.invoice', compact('sale'));
    }
}
