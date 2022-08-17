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
