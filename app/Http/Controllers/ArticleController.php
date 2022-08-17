<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $searchQuery = $request->query('search');

        if ($searchQuery !== null)
        {
            $articles = Article::with('category')->select([
                'category_id', 'title', 'slug', 'content_preview', 'content', 'featured_image',
            ])
                ->where('title', 'like', '%' . $searchQuery . '%')
                ->paginate()
            ;
        }
        else
        {
            $articles = Article::with('category')->select([
                'category_id', 'title', 'slug', 'content_preview', 'content', 'featured_image',
            ])
                ->paginate()
            ;
        }

        return response()->json([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Articles fetched successfully.',
            ],
            'data' => $articles,
        ]);
    }
}
