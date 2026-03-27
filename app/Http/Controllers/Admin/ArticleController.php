<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Throwable;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Comment;
use App\Models\User;
use App\Notifications\CreateArticleNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Kreait\Firebase\Messaging\CloudMessage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('pages.articles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $tags = Tag::all();
        $categories = Category::whereNotIn('name', ['Produk', 'Karya Mahasiswa'])->get();

        $data = [
            'categories' => $categories,
            'tags' => $tags,
        ];

        return view('pages.articles.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $validated['user_id'] = Auth::id();
            $validated['slug'] = Str::slug($validated['title']);

            $body = $validated['content'];
            $embed = $validated['embed'] ?? null;
            if ($embed) {
                $combined = '
                    <div class="article-wrapper">
                        <div class="article-body">' . $body . '</div>
                        <div class="article-embed">' . $embed . '</div>
                    </div>
                ';
            } else {
                $combined = '
                    <div class="article-wrapper">
                        <div class="article-body">' . $body . '</div>
                    </div>
                ';
            }
            $validated['content'] = $combined;

            $path = Storage::put('thumbnails', $request->file('thumbnail'));
            $validated['thumbnail'] = $path;

            $article = Article::create($validated);

            $tags = $validated['tags'] ?? [];
            if ($tags) {
                $tagIds = Tag::whereIn('id', $tags)->pluck('id')->toArray();
                $article->tags()->sync($tagIds);
            }

            DB::commit();

            $notification = $this->sendNotifications($article, 'Artikel baru telah dipublikasikan');
            $notifMsg = sprintf(
                'Artikel berhasil dibuat. Notifikasi berhasil: %d, gagal: %d',
                $notification['success'] ?? 0,
                $notification['failed'] ?? 0
            );

            return redirect()
                ->route('articles.index')
                ->with('success', $notifMsg);
        } catch (Throwable $th) {
            DB::rollBack();
            Log::error('Error creating article: ' . $th->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan artikel.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article): View
    {
        $data = [
            'article' => $article,
        ];

        return view('pages.articles.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article): View
    {
        $content = $article->content;
        $embed = '';

        // Extract embed
        if (preg_match('/<div[^>]*class=["\']article-embed["\'][^>]*>(.*?)<\/div>/is', $content, $m)) {
            $embed = $m[1];
            $content = preg_replace('/<div[^>]*class=["\']article-embed["\'][^>]*>.*?<\/div>/is', '', $content, 1);
        }

        // Extract body + fallback
        if (preg_match('/<div[^>]*class=["\']article-body["\'][^>]*>(.*?)<\/div>/is', $content, $m2)) {
            $content = $m2[1];
        } else {
            if (preg_match('/<div[^>]*class=["\']article-wrapper["\'][^>]*>(.*?)<\/div>/is', $content, $m3)) {
                $content = $m3[1];
            }
        }

        $articleForEdit = clone $article;
        $articleForEdit->content = $content;
        $articleForEdit->embed = $embed;

        $data = [
            'article' => $articleForEdit,
            'categories' => Category::whereNotIn('name', ['Produk', 'Karya Mahasiswa'])->get(),
            'tags' => Tag::all(),
        ];

        return view('pages.articles.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, Article $article): RedirectResponse
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $validated['slug'] = Str::slug($validated['title']);

            $body = $validated['content'];
            $embed = $validated['embed'] ?? null;
            if ($embed) {
                $combined = '
                    <div class="article-wrapper">
                        <div class="article-body">' . $body . '</div>
                        <div class="article-embed">' . $embed . '</div>
                    </div>
                ';
            } else {
                $combined = '
                    <div class="article-wrapper">
                        <div class="article-body">' . $body . '</div>
                    </div>
                ';
            }
            $validated['content'] = $combined;

            if ($request->hasFile('thumbnail')) {
                if (Storage::exists($article->thumbnail)) {
                    Storage::delete($article->thumbnail);
                }

                $path = Storage::put('thumbnails', $request->file('thumbnail'));
                $validated['thumbnail'] = $path;
            }

            $article->update($validated);

            $tags = $validated['tags'] ?? [];
            if ($tags) {
                $tagIds = Tag::whereIn('id', $tags)->pluck('id')->toArray();
                $article->tags()->sync($tagIds);
            }

            DB::commit();

            return redirect()
                ->route('articles.index')
                ->with('success', 'Artikel berhasil diperbaharui.');
        } catch (Throwable $th) {
            DB::rollBack();
            Log::error('Error updating article: ' . $th->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbaharui artikel.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article): RedirectResponse
    {
        $article->delete();

        return back()->with('success', 'Artikel berhasil dihapus.');
    }

    /**
     * Get paginated articles data for datatable.
     */
    public function datatable(Request $request): JsonResponse
    {
        $query = Article::query()->with('user', 'category', 'tags');

        // Handle search
        $search = $request->input('search');
        if (!empty($search)) {
            $searchLower = strtolower($search);
            if ($searchLower === 'aktif') {
                $query->where('is_active', true);
            } elseif ($searchLower === 'tidak aktif') {
                $query->where('is_active', false);
            } elseif ($searchLower === 'disematkan') {
                $query->where('is_pinned', true);
            } elseif ($searchLower === 'tidak disematkan') {
                $query->where('is_pinned', false);
            } else {
                $query->where(function ($q) use ($search) {
                    $q->orWhere('title', 'like', "%{$search}%")
                        ->orWhere('created_at', 'like', "%{$search}%")
                        ->orWhere('updated_at', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('category', function ($categoryQuery) use ($search) {
                            $categoryQuery->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('tags', function ($tagQuery) use ($search) {
                            $tagQuery->where('name', 'like', "%{$search}%");
                        });
                });
            }
        }

        // Handle sorting
        $sortField = $request->input('sortField');
        $sortOrder = $request->input('sortOrder');
        if (!empty($sortOrder) && !empty($sortField)) {
            if ($sortField === 'user_name') {
                $query->join('users', 'articles.user_id', '=', 'users.id')
                    ->orderBy('users.name', $sortOrder)
                    ->select('articles.*');
            } elseif ($sortField === 'category_name') {
                $query->join('categories', 'articles.category_id', '=', 'categories.id')
                    ->orderBy('categories.name', $sortOrder)
                    ->select('articles.*');
            } elseif ($sortField === 'tag_names') {
                $query->leftJoin('article_tag', 'articles.id', '=', 'article_tag.article_id')
                    ->leftJoin('tags', 'article_tag.tag_id', '=', 'tags.id')
                    ->groupBy('articles.id')
                    ->orderByRaw("GROUP_CONCAT(tags.name ORDER BY tags.name SEPARATOR ', ') $sortOrder")
                    ->select('articles.*');
            } else {
                $query->orderBy($sortField, $sortOrder);
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Get pagination parameters
        $page = $request->input('page', 1);
        $size = $request->input('size', 5);
        $articles = $query->paginate($size, ['*'], 'page', $page);

        // Format data for KTUI datatable
        $data = $articles->map(function ($article) {
            return [
                'title' => $article->title,
                'user_name' => $article->user->name,
                'category_name' => $article->category->name,
                'tag_names' => $article->tags->pluck('name')->toArray(),
                'is_active' => $article->is_active ? 'Aktif' : 'Tidak Aktif',
                'is_pinned' => $article->is_pinned ? 'Disematkan' : 'Tidak Disematkan',
                'created_at' => $article->created_at->translatedFormat('d M Y H:i'),
                'updated_at' => $article->updated_at->translatedFormat('d M Y H:i'),
                'actions' => [
                    'show' => route('articles.show', $article->id),
                    'edit' => route('articles.edit', $article->id),
                    'delete' => route('articles.destroy', $article->id),
                ],
            ];
        });

        $response = [
            'data' => $data,
            'page' => $articles->currentPage(),
            'totalPages' => $articles->lastPage(),
            'pageSize' => $articles->perPage(),
            'totalCount' => $articles->total(),
        ];

        return response()->json($response);
    }

    /**
     * Handle CKEditor image upload
     */
    public function uploadImage(Request $request): JsonResponse
    {
        $path = Storage::put('contents', $request->file('upload'));
        $url = route('files', $path);

        return response()->json([
            'url' => $url
        ]);
    }

    /**
     * Delete a comment from an article.
     */
    public function deleteComment(Comment $comment): RedirectResponse
    {
        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus.');
    }

    /**
     * Send notifications to all users about the new article.
     */
    private function sendNotifications(Article $article, string $title): array
    {
        $users = User::all();
        foreach ($users as $user) {
            $user->notify(new CreateArticleNotification($article));
        }

        $tokens = $users
            ->pluck('fcm_token')
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        if (empty($tokens)) {
            return [
                'success' => 0,
                'failed' => 0,
            ];
        }

        try {
            $messaging = app('firebase.messaging');

            $message = CloudMessage::new()
                ->withData([
                    'title' => $title,
                    'body' => $article->title,
                    'image' => route('files', $article->thumbnail),
                    'url' => route('detail', $article->slug),
                ]);

            $report = $messaging->sendMulticast($message, $tokens);

            return [
                'success' => $report->successes()->count(),
                'failed' => $report->failures()->count(),
            ];
        } catch (Throwable $th) {
            Log::error('Error sending article notifications: ' . $th->getMessage());

            return [
                'success' => 0,
                'failed' => count($tokens),
            ];
        }
    }
}
