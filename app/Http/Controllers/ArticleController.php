<?php

namespace App\Http\Controllers;

use App\Models\Article;

class ArticleController extends Controller
{
    /** Halaman detail 1 artikel (tombol "Baca →" dari Home mengarah ke sini). */
    public function show(string $slug)
    {
        $article = Article::where('slug', $slug)->published()->firstOrFail();

        $related = Article::published()
            ->where('id', '!=', $article->id)
            ->limit(3)
            ->get();

        return view('articles.show', compact('article', 'related'));
    }
}