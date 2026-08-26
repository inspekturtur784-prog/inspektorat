<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Services\ImageConverter;
use Illuminate\Http\Request;

/**
 * CRUD Artikel untuk sisi Admin.
 * NOTE: pasang middleware auth (mis. 'auth', 'can:admin') di route group-nya
 * di routes/web.php sebelum dipakai di production — lihat komentar di sana.
 */
class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::orderByDesc('created_at')->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'excerpt'      => 'nullable|string|max:300',
            'body'         => 'nullable|string',
            'category'     => 'nullable|string|max:100',
            'is_published' => 'nullable|boolean',
            'cover_image'  => 'nullable|image|max:2048',
            'published_at' => 'nullable|date',
        ]);

        // Foto sampul otomatis dikompresi & dikonversi ke WebP.
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = ImageConverter::toWebp(
                $request->file('cover_image'),
                public_path('images/articles')
            );
        }

        $data['is_published'] = $request->boolean('is_published');
        $data['published_at'] = $data['published_at'] ?? now();

        Article::create($data);

        return redirect()->route('admin.articles.index')->with('status', 'Artikel berhasil ditambahkan.');
    }

    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'excerpt'      => 'nullable|string|max:300',
            'body'         => 'nullable|string',
            'category'     => 'nullable|string|max:100',
            'is_published' => 'nullable|boolean',
            'cover_image'  => 'nullable|image|max:2048',
            'published_at' => 'nullable|date',
        ]);

        // Foto sampul otomatis dikompresi & dikonversi ke WebP.
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = ImageConverter::toWebp(
                $request->file('cover_image'),
                public_path('images/articles')
            );
        }

        $data['is_published'] = $request->boolean('is_published');

        $article->update($data);

        return redirect()->route('admin.articles.index')->with('status', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('admin.articles.index')->with('status', 'Artikel berhasil dihapus.');
    }
}