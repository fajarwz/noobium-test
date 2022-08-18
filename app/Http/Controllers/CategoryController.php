<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::get(['name', 'slug']);

        return response()->json([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Categories fetched successfully.',
            ],
            'data' => $categories,
        ]);
    }

    public function show($categorySlug)
    {
        $category = Category::where('slug', $categorySlug)->first();

        if ($category)
        {
            $articles = Category::find($category->id)->articles()->with('category')->paginate();

            return response()->json([
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Articles fetched successfully.',
                ],
                'data' => $articles,
            ]);

        }

        return response()->json([
            'meta' => [
                'code' => 404,
                'status' => 'error',
                'message' => 'Category not found.',
            ],
            'data' => [],
        ], 404);
        
    }
}
