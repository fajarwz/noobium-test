<?php

namespace App\Http\Controllers\Me;

use App\Http\Controllers\Controller;
use App\Http\Requests\Me\Article\StoreRequest;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('category')->select([
            'category_id', 'title', 'slug', 'content_preview', 'content', 'featured_image',
        ])
        ->where('user_id', auth()->id())
        ->paginate();

        return response()->json([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Articles fetched successfully.',
            ],
            'data' => $articles,
        ]);
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();

        $validated['slug'] = Str::of($validated['title'])->slug('-');
        $validated['content_preview'] = substr($validated['content'], 0, 218) . '...';

        if ($request->hasFile('featured_image'))
        {
            $validated['featured_image'] = $request->file('featured_image')->store('article/featured-image', 'public');
        }

        $createArticle = User::find(auth()->id())->articles()->create($validated);

        if ($createArticle)
        {
            return response()->json([
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Article created successfully.',
                ],
                'data' => [],
            ]);
        }

        return response()->json([
            'meta' => [
                'code' => 500,
                'status' => 'error',
                'message' => 'Error! Article failed to create.',
            ],
            'data' => [],
        ], 500);
    }
}