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
        $products = Product::with('category')->get();
        return view('pages.products.index', compact('products'));
    }


    public function create()
    {
        $categories = Category::get();
        return view('pages.products.create', compact('categories'));
    }
    // Product save function
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'price_per_unit' => 'required|numeric|min:0',
            'unit'        => 'nullable|string',
            'barcode'     => 'nullable|string|unique:products,barcode',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|image|max:2048',
        ]);

        // Auto-generate barcode if not provided
        $barcode = $request->barcode ?? str_pad(mt_rand(1, 9999999999999), 13, '0', STR_PAD_LEFT);

        // Image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // Save product
        $product = Product::create([
            'category_id'   => $request->category_id,
            'name'          => $request->name,
            'price_per_unit' => $request->price_per_unit,
            'unit'          => $request->unit ?? 'pcs',
            'barcode'       => $barcode,
            'stock'         => $request->stock,
            'image'         => $imagePath,
        ]);

        // Step 5: Return response
        return response()->json([
            'status'  => 'success',
            'message' => 'Product added successfully!',
            'redirect' => route('product.index'),
        ]);
    }



    public function edit($id)
    {
        $product = Product::with('category')->findOrFail($id);
        $categories = Category::all();

        return view('pages.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'name'           => 'required|string|max:255',
            'price_per_unit' => 'required|numeric|min:0',
            'unit'           => 'nullable|string',
            'barcode'        => 'nullable|string|unique:products,barcode,' . $product->id,
            'stock'          => 'required|integer|min:0',
            'image'          => 'nullable|image|max:2048',
        ]);

        // Auto-generate barcode if not provided
        $barcode = $request->barcode ?? $product->barcode ?? str_pad(mt_rand(1, 9999999999999), 13, '0', STR_PAD_LEFT);

        // Image upload (replace if new image uploaded)
        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // Update product
        $product->update([
            'category_id'    => $request->category_id,
            'name'           => $request->name,
            'price_per_unit' => $request->price_per_unit,
            'unit'           => $request->unit ?? 'pcs',
            'barcode'        => $barcode,
            'stock'          => $request->stock,
            'image'          => $imagePath,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Product updated successfully!',
            'redirect' => route('product.index'),
        ]);
    }


    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Agar image stored hai to delete karna optional hai
        if ($product->image && \Storage::disk('public')->exists($product->image)) {
            \Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Product deleted successfully!',
            'redirect' => route('product.index'),
        ]);
    }

    public function findByBarcode(Request $request)
    {
        $barcode = $request->query('barcode');

        if (!$barcode) {
            return response()->json([
                'status' => 'error',
                'message' => 'Barcode is required'
            ], 422);
        }

        // Product find by barcode
        $product = \App\Models\Product::where('barcode', $barcode)->first();

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'status'       => 'success',
            'id'           => $product->id,
            'name'         => $product->name,
            'barcode'      => $product->barcode,
            'price_per_unit' => $product->price_per_unit,
            'stock'        => $product->stock,
            'unit'         => $product->unit,
            'image'        => $product->image
                ? asset('storage/' . $product->image)
                : asset('images/no-image.png'),
            'category'     => $product->category->name ?? null, // relation se category ka name
        ]);
    }


    public function search(Request $request)
    {
        $query = $request->get('name');

        if (!$query) {
            return response()->json([]);
        }

        // ✅ Products search by name
        $products = Product::with('category')
            ->where('name', 'LIKE', "%{$query}%")
            ->limit(10)
            ->get(['id', 'category_id', 'name', 'barcode', 'price_per_unit', 'stock', 'unit', 'image']);

        // ✅ Transform result
        $results = $products->map(function ($product) {
            return [
                'id'          => $product->id,
                'name'        => $product->name,
                'barcode'     => $product->barcode,
                'price'       => $product->price_per_unit,
                'stock'       => $product->stock,
                'unit'        => $product->unit,
                'image'       => $product->image
                    ? asset('storage/' . $product->image)
                    : asset('images/no-image.png'),
                'category'    => $product->category->name ?? null,
            ];
        });

        return response()->json($results);
    }
}
