<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

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
            $articles = Category::find($category->id)
                ->articles()
                ->with(['category', 'user:id,name,picture'])
                ->select([
                    'id', 'user_id', 'category_id', 'title', 'slug', 'content_preview', 'featured_image', 'created_at', 'updated_at'
                ])
                ->paginate()
            ;

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
