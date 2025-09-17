<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('pages.category.index');
    }

    public function create()
    {
        return view('pages.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'slug'  => 'required|string|max:255|unique:categories,slug',
            'status' => 'required',
            'filename' => 'nullable|image',
        ]);

        $imagePath = null;

        if ($request->hasFile('filename')) {
            $imagePath = $request->file('filename')->store('categories', 'public');
        }

        Category::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'status' => $request->status == "on" ? 'active' : $request->status,
            'image' => $imagePath,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Category created successfully!',
            'redirect' => route('category.index'),
        ]);
    }
}
