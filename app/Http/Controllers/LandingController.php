<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Embed;
use App\Models\Slider;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
    public function index()
    {
        $data = [
            'sliders' => Slider::all(),
            'pinnedArticles' => Article::where('is_pinned', true)
                ->where('is_active', true)
                ->latest()
                ->limit(3)
                ->get(),
            'berita' => Article::where('category_id', 1)
                ->where('is_active', true)
                ->latest()
                ->limit(3)
                ->get(),
            'buletin' => Article::where('category_id', 2)
                ->where('is_active', true)
                ->latest()
                ->limit(2)
                ->get(),
            'majalah' => Article::with('category')->where('category_id', 13)
                ->where('is_active', true)
                ->latest()
                ->limit(2)
                ->get(),
            'resensi_buku' => Article::with('category')->where('category_id', 4)
                ->where('is_active', true)
                ->latest()
                ->limit(2)
                ->get(),
            'review_film' => Article::with('category')->where('category_id', 5)
                ->where('is_active', true)
                ->latest()
                ->limit(2)
                ->get(),
            'opini' => Article::with('category')->where('category_id', 6)
                ->where('is_active', true)
                ->latest()
                ->limit(2)
                ->get(),
            'esai' => Article::with('category')->where('category_id', 7)
                ->where('is_active', true)
                ->latest()
                ->limit(2)
                ->get(),
            'artikel' => Article::with('category')->where('category_id', 8)
                ->where('is_active', true)
                ->latest()
                ->limit(2)
                ->get(),
            'puisi' => Article::with('category')->where('category_id', 9)
                ->where('is_active', true)
                ->latest()
                ->limit(2)
                ->get(),
            'cerpen' => Article::with('category')->where('category_id', 10)
                ->where('is_active', true)
                ->latest()
                ->limit(2)
                ->get(),
            'gaya_mahasiswa' => Article::where('category_id', 11)
                ->where('is_active', true)
                ->latest()
                ->limit(3)
                ->get(),
        ];

        return view('pages.landing.index', compact('data'));
    }

    public function show($slug)
    {
        $article = Article::with(['user', 'category', 'tags', 'comments.user'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        Article::where('id', $article->id)->increment('views');

        $data = [
            'article' => $article,
            'relatedArticles' => Article::where('category_id', $article->category_id)
                ->where('is_active', true)
                ->where('id', '!=', $article->id)
                ->latest()
                ->limit(3)
                ->get(),
        ];

        return view('pages.landing.show', compact('data'));
    }

    public function like(Request $request)
    {
        $article = Article::where('slug', $request->input('slug'))
            ->where('is_active', true)
            ->firstOrFail();

        $article->increment('likes');

        return redirect()->route('detail', $request->input('slug'))->with('success', 'Terima kasih telah menyukai artikel ini!');
    }

    public function comment(CommentRequest $request)
    {
        $article = Article::where('slug', $request->input('slug'))
            ->where('is_active', true)
            ->firstOrFail();

        $article->comments()->create([
            'article_id' => $article->id,
            'user_id' => Auth::id(),
            'content' => $request->input('content'),
            'is_active' => true,
        ]);

        return redirect()->route('detail', $request->input('slug'))->with('success', 'Komentar Anda telah ditambahkan.');
    }

    public function category(Category $category)
    {
        $data = [
            'category' => $category,
            'articles' => $category->articles()
                ->with(['user', 'category', 'tags'])
                ->where('is_active', true)
                ->latest()
                ->paginate(9),
        ];

        return view('pages.landing.category', compact('data'));
    }

    public function tag(Tag $tag)
    {
        $data = [
            'tag' => $tag,
            'articles' => $tag->articles()
                ->where('is_active', true)
                ->latest()
                ->paginate(12),
        ];

        return view('pages.landing.tag', compact('data'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        $data = [
            'query' => $query,
            'articles' => Article::where('is_active', true)
                ->where(function ($q) use ($query) {
                    $q->where('title', 'LIKE', "%{$query}%")
                        ->orWhere('content', 'LIKE', "%{$query}%");
                })
                ->latest()
                ->paginate(12),
        ];

        return view('pages.landing.search', compact('data'));
    }
}
