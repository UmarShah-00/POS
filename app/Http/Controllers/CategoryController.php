<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::get();
        return view('pages.category.index', compact('categories'));
    }

    public function create()
    {
        return view('pages.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'filename' => 'nullable|image',
        ]);

        $imagePath = null;

        if ($request->hasFile('filename')) {
            $imagePath = $request->file('filename')->store('categories', 'public');
        }

        Category::create([
            'name' => $request->name,
            'image' => $imagePath,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Category created successfully!',
            'redirect' => route('category.index'),
        ]);
    }

    public function edit($id)
    {
        $edit = Category::find($id);
        return view('pages.category.edit', compact('edit'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'filename' => 'nullable|image'
        ]);

        $category = Category::findOrFail($id);

        // ✅ Update basic fields
        $category->name   = $request->name;

        // ✅ If new image uploaded
        if ($request->hasFile('filename')) {
            $imagePath = $request->file('filename')->store('categories', 'public');
            $category->image = $imagePath;
        }

        $category->save();

        return response()->json([
            'status'   => 'success',
            'message'  => 'Category updated successfully!',
            'redirect' => route('category.index')
        ]);
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found.'
            ], 404);
        }

        $category->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'category deleted successfully!'
        ]);
    }
}
