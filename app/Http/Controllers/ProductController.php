<?php

namespace App\Http\Controllers;

use Storage;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'variants'])->get();
        return view('pages.products.index', compact('products'));
    }


    public function create()
    {
        $categories = Category::get();
        return view('pages.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'unit'        => 'nullable|string',
            // Variant fields
            'barcode'     => 'nullable|string|unique:product_variants,barcode',
            'stock'       => 'required|integer|min:0',
            'expiry_date' => 'nullable|date',
            'image'       => 'nullable|image',
        ]);

        // Step 1: Product create
        $product = Product::create([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'price'       => $request->price,
            'unit'        => $request->unit ?? 'pcs',
        ]);

        // Step 2: Barcode generate if not provided
        $barcode = $request->barcode ?? str_pad(mt_rand(1, 9999999999999), 13, '0', STR_PAD_LEFT);

        // Step 3: Image upload (for variant)
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // Step 4: Variant create
        $variant = $product->variants()->create([
            'barcode'     => $barcode,
            'stock'       => $request->stock,
            'expiry_date' => $request->expiry_date,
            'image'       => $imagePath,
        ]);

        // Step 5: Return response
        return response()->json([
            'status'  => 'success',
            'message' => 'Product and variant added successfully!',
            'product' => $product->load('variants'),
            'redirect' => route('product.index'),
        ]);
    }


    public function edit($id)
    {
        $product = Product::with(['category', 'variants'])->findOrFail($id);
        $categories = Category::all();

        return view('pages.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::with('variants')->findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'unit'        => 'nullable|string|max:50',

            // Variant fields
            'stock'       => 'required|integer|min:0',
            'expiry_date' => 'nullable|date',
            'barcode'     => 'nullable|string|unique:product_variants,barcode,' . ($product->variants->first()->id ?? 'null'),
            'image'       => 'nullable|image',
        ]);

        // ✅ Step 1: Update Product
        $product->update([
            'name'        => $request->name,
            'category_id' => $request->category_id,
            'price'       => $request->price,
            'unit'        => $request->unit ?? 'pcs',
        ]);

        // ✅ Step 2: Update (first/default) Variant
        $variant = $product->variants->first();
        if ($variant) {
            $variant->barcode     = $request->barcode ?: $variant->barcode;
            $variant->stock       = $request->stock;
            $variant->expiry_date = $request->expiry_date;

            if ($request->hasFile('image')) {
                $variant->image = $request->file('image')->store('products', 'public');
            }

            $variant->save();
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Product and variant updated successfully!',
            'redirect' => route('product.index'),
        ]);
    }


    public function destroy($id)
    {
        $product = Product::with('variants')->findOrFail($id);

        // ✅ Delete all variant images first
        foreach ($product->variants as $variant) {
            if ($variant->image && Storage::disk('public')->exists($variant->image)) {
                Storage::disk('public')->delete($variant->image);
            }
        }

        // ✅ Delete product (cascade will delete variants)
        $product->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Product and its variants deleted successfully!'
        ]);
    }


    public function findByBarcode(Request $request)
    {
        $barcode = $request->query('barcode');

        if (!$barcode) {
            return response()->json(['message' => 'Barcode required'], 422);
        }

        // ✅ Find variant by barcode
        $variant = \App\Models\ProductVariant::with('product')->where('barcode', $barcode)->first();

        if (!$variant) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json([
            'id'        => $variant->id,
            'name'      => $variant->product->name,   // parent product ka naam
            'barcode'   => $variant->barcode,
            'price'     => $variant->product->price,  // price parent product se aayegi
            'stock'     => $variant->stock,
            'unit'      => $variant->product->unit,
            'expiry_date' => $variant->expiry_date,
            'image'     => $variant->image
                ? asset('storage/' . $variant->image)
                : asset('images/no-image.png'),
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->get('name');

        if (!$query) {
            return response()->json([]);
        }

        // ✅ Product + Variant dono fetch karna
        $variants = \App\Models\ProductVariant::with('product')
            ->whereHas('product', function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->limit(10)
            ->get(['id', 'product_id', 'barcode', 'stock', 'expiry_date', 'image']);

        // ✅ Transform result
        $results = $variants->map(function ($variant) {
            return [
                'id'        => $variant->id,
                'name'      => $variant->product->name,
                'barcode'   => $variant->barcode,
                'price'     => $variant->product->price,
                'stock'     => $variant->stock,
                'expiry_date' => $variant->expiry_date,
                'image'     => $variant->image
                    ? asset('storage/' . $variant->image)
                    : asset('images/no-image.png'),
            ];
        });

        return response()->json($results);
    }
}
