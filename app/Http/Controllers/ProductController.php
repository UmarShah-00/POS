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

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'barcode' => 'nullable|string|unique:products,barcode',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'unit' => 'nullable|string',
            'expiry_date' => 'nullable|date',
            'image' => 'nullable|image',
        ]);


        // Auto generate barcode if not provided
        $barcode = $request->barcode ?? str_pad(mt_rand(1, 9999999999999), 13, '0', STR_PAD_LEFT);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product = Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'barcode' => $barcode,
            'price' => $request->price,
            'stock' => $request->stock,
            'unit' => $request->unit,
            'expiry_date' => $request->expiry_date,
            'image' => $imagePath,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Product added successfully!',
            'product' => $product,
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
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'unit'        => 'nullable|string|max:50',
            'expiry_date' => 'nullable|date',
            'barcode'     => 'nullable|string|unique:products,barcode,' . $product->id,
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $product->name        = $request->name;
        $product->category_id = $request->category_id;
        $product->price       = $request->price;
        $product->stock       = $request->stock;
        $product->unit        = $request->unit;
        $product->expiry_date = $request->expiry_date;
        $product->barcode     = $request->barcode ?: $product->barcode;

        if ($request->hasFile('image')) {
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Product updated successfully!',
            'redirect' => route('product.index')
        ]);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Agar image hai to delete kar do
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            \Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Product deleted successfully!'
        ]);
    }
}
