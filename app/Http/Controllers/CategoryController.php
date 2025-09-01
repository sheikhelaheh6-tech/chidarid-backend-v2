<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = $request->user()->categories;
        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }
    public function store(CategoryRequest $request)
    {
        $category = $request->user()->categories()->create($request->validated());
        return response()->json($category);
    }
    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        return response()->json($category);
    }
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(['message' => 'حذف شد']);
    }
}
