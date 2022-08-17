<?php

namespace App\Http\Controllers\Me;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index()
    {
        $article = Article::where('user_id', auth()->id())->get();

        return response()->json([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Articles fetched successfully.',
            ],
            'data' => [
                'title' => $article->title,
                'slug' => $article->slug,
                'content_preview' => $article->content_preview,
                'content' => $article->content,
                'featured_image' => $article->featured_image,
            ],
        ]);
    } 
}
