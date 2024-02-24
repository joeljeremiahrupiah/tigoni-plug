<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::with('products')->latest()->get();
        return response()->json(['categories' => $categories]);
    }

    public function getAllCategories()
    {
        $categories = Category::with('products')->latest()->get();
        return response()->json(['categories' => $categories]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $category = Category::create([
            'slug' => \Str::uuid(),
            'title' => $request->title
        ]);

        return response()->json(['category' => $category, 'message' => 'Category created successfully', 'status' => 200], 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $category = Category::findOrFail($id);
        $category->title = $request->title;
        $category->save();

        return response()->json(['category' => $category, 'message' => 'Category updated successfully', 'status' => 200], 200);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully', 'status' => 200], 200);
    }
}
