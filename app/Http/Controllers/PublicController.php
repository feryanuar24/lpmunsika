<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Slider;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PublicController extends Controller
{
    /**
     * Display the landing page.
     */
    public function landing(): View
    {
        // Get pinned articles
        $pinned = Article::with(['user', 'category', 'tags'])
            ->where('is_pinned', true)
            ->where('is_active', true)
            ->latest()
            ->limit(3)
            ->get();

        // Get categories with their articles dynamically
        $categories = Category::with(['children', 'articles' => function ($query) {
            $query->where('is_active', true)->latest();
        }])->whereNull('parent_id')->get();

        // Build category data with articles for each child
        $categoryData = [];
        foreach ($categories as $parentCategory) {
            if ($parentCategory->children->count() > 0) {
                $categoryData[$parentCategory->name] = [
                    'type' => 'parent',
                    'children' => []
                ];
                foreach ($parentCategory->children as $childCategory) {
                    $categoryData[$parentCategory->name]['children'][$childCategory->name] = $childCategory->articles()
                        ->where('is_active', true)
                        ->latest()
                        ->limit(2)
                        ->get();
                }
            } else {
                $categoryData[$parentCategory->name] = [
                    'type' => 'standalone',
                    'articles' => $parentCategory->articles()
                        ->where('is_active', true)
                        ->latest()
                        ->limit(4)
                        ->get()
                ];
            }
        }

        $data = [
            'sliders' => Slider::all(),
            'pinned' => $pinned,
            'categories' => $categoryData,
        ];

        return view('pages.public.landing', compact('data'));
    }

    /**
     * Search articles by query.
     */
    public function search(Request $request): View
    {
        $validated = $request->validate([
            'query' => ['required', 'string', 'max:255'],
        ]);

        $data = [
            'query' => $validated['query'],
            'articles' => Article::with(['user', 'category', 'tags'])
                ->where('is_active', true)
                ->where(function ($q) use ($validated) {
                    $q->where('title', 'LIKE', "%{$validated['query']}%")
                        ->orWhere('content', 'LIKE', "%{$validated['query']}%");
                })
                ->latest()
                ->paginate(10),
        ];

        return view('pages.public.search', compact('data'));
    }

    /**
     * Display articles by category.
     */
    public function category(Category $category): View
    {
        $data = [
            'category' => $category,
            'articles' => $category->articles()
                ->with(['user', 'category', 'tags'])
                ->where('is_active', true)
                ->latest()
                ->paginate(10),
        ];

        return view('pages.public.category', compact('data'));
    }

    /**
     * Display articles by tag.
     */
    public function tag(Tag $tag): View
    {
        $data = [
            'tag' => $tag,
            'articles' => $tag->articles()
                ->with(['user', 'category', 'tags'])
                ->where('is_active', true)
                ->latest()
                ->paginate(10),
        ];

        return view('pages.public.tag', compact('data'));
    }

    /**
     * Display article details.
     */
    public function detail(Article $article): View
    {
        $article->increment('views');

        $data = [
            'article' => $article,
            'related' => Article::where('category_id', $article->category_id)
                ->where('is_active', true)
                ->where('id', '!=', $article->id)
                ->latest()
                ->limit(3)
                ->get(),
        ];

        return view('pages.public.detail', compact('data'));
    }

    /**
     * Handle liking an article.
     */
    public function like(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'slug' => ['required', Rule::exists('articles', 'slug')->whereNull('deleted_at')],
        ]);

        $article = Article::where('slug', $validated['slug'])
            ->where('is_active', true)
            ->firstOrFail();

        $article->increment('likes');

        return redirect()->route('detail', $validated['slug'])->with('success', 'Terima kasih telah menyukai artikel ini!');
    }

    /**
     * Handle commenting on an article.
     */
    public function comment(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'slug' => ['required', Rule::exists('articles', 'slug')->whereNull('deleted_at')],
            'content' => ['required', 'string', 'max:1000'],
        ]);

        $article = Article::where('slug', $validated['slug'])
            ->where('is_active', true)
            ->firstOrFail();

        $article->comments()->create([
            'user_id' => Auth::id(),
            'content' => $validated['content'],
            'is_active' => true,
        ]);

        return redirect()->route('detail', $validated['slug'])->with('success', 'Komentar Anda telah ditambahkan.');
    }
}
