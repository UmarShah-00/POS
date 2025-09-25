<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;

class PosController extends Controller
{
    public function checkout(Request $request)
    {
        $cart = $request->input('cart');
        if (!is_array($cart) || count($cart) === 0) {
            return response()->json(['status' => 'error', 'message' => 'Cart is empty'], 422);
        }

        foreach ($cart as $c) {
            if (!isset($c['id']) || !isset($c['qty']) || !isset($c['price'])) {
                return response()->json(['status' => 'error', 'message' => 'Invalid cart data'], 422);
            }
        }

        DB::beginTransaction();
        try {
            $total = 0;
            foreach ($cart as $c) {
                $product = Product::find($c['id']);
                if (!$product) {
                    DB::rollBack();
                    return response()->json(['status' => 'error', 'message' => 'Product not found: id ' . $c['id']], 404);
                }

                $unit = strtolower($product->unit);
                $qty = intval($c['qty']); // grams/ml/pieces
                $price = floatval($c['price']); // price per kg/litre/piece

                // ✅ Agar kg/litre hai to grams/ml ko kg/litre me convert karo
                if ($unit === 'kg' || $unit === 'litre') {
                    $subtotal = ($qty / 1000) * $price;
                } else {
                    $subtotal = $qty * $price;
                }

                $total += $subtotal;
            }

            $sale = Sale::create([
                'total_amount' => $total,
            ]);

            $sale->invoice_no = str_pad($sale->id, 6, '0', STR_PAD_LEFT);
            $sale->save();

            foreach ($cart as $c) {
                $product = Product::find($c['id']);
                $unit = strtolower($product->unit);
                $qty = intval($c['qty']);
                $price = floatval($c['price']);

                if ($product->stock < $qty) {
                    DB::rollBack();
                    return response()->json([
                        'status' => 'error',
                        'message' => "Insufficient stock for product {$product->name}"
                    ], 400);
                }

                // ✅ Line subtotal fix
                if ($unit === 'kg' || $unit === 'litre') {
                    $subtotal = ($qty / 1000) * $price;
                } else {
                    $subtotal = $qty * $price;
                }

                // ✅ Save original qty (grams/ml/pieces) in DB
                SaleItem::create([
                    'sale_id'   => $sale->id,
                    'product_id' => $product->id,
                    'quantity'  => $qty,     // hamesha smallest unit
                    'price'     => $price,   // per kg/litre/piece
                    'subtotal'  => $subtotal,
                ]);

                // ✅ Stock decrement
                $product->decrement('stock', $qty);
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

    public function invoice($id)
    {
        $sale = Sale::with('items.product')->findOrFail($id);
        return view('pages.pos.invoice', compact('sale'));
    }
}
