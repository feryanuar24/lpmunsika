<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Notification;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Throwable;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ArticleRequest;
use App\Http\Requests\UploadImageRequest;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.articles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::all();

        $data = [
            'categories' => Category::all(),
            'tags' => $tags,
        ];

        return view('pages.articles.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->except(['thumbnail', 'tags', 'embed']);

            $data['user_id'] = Auth::id();
            $data['slug'] = Str::slug($request->input('title'));

            $body = $request->input('content');
            $embedHtml = $request->filled('embed') ? $request->input('embed') : '';
            if ($embedHtml) {
                $combined = '<div class="article-wrapper">'
                    . '<div class="article-body">' . $body . '</div>'
                    . '<div class="article-embed">' . $embedHtml . '</div>'
                    . '</div>';
            } else {
                $combined = '<div class="article-wrapper">'
                    . '<div class="article-body">' . $body . '</div>'
                    . '</div>';
            }

            $data['content'] = $combined;

            if ($request->hasFile('thumbnail')) {
                $path = Storage::put('thumbnails', $request->file('thumbnail'));
                $data['thumbnail'] = $path;
            }

            $article = Article::create($data);

            if ($request->filled('tags')) {
                $tagIds = Tag::whereIn('name', $request->input('tags'))->pluck('id')->toArray();
                $article->tags()->sync($tagIds);
            }

            Notification::create([
                'user_id' => Auth::id(),
                'title' => 'Artikel Ditambahkan',
                'message' => 'Artikel ' . $article->title . ' berhasil ditambahkan oleh ' . (Auth::user()->name ?? 'Anonim') . '.',
            ]);

            DB::commit();

            return redirect()
                ->route('articles.index')
                ->with('success', 'Artikel berhasil dibuat.');
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
    public function show(Article $article)
    {
        $data = [
            'article' => $article,
        ];

        return view('pages.articles.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $content = $article->content;
        $embed = '';

        if (preg_match('/<div[^>]*class=["\']article-embed["\'][^>]*>(.*?)<\/div>/is', $content, $m)) {
            $embed = $m[1];
            $content = preg_replace('/<div[^>]*class=["\']article-embed["\'][^>]*>.*?<\/div>/is', '', $content, 1);
        }

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
            'categories' => Category::all(),
            'tags' => Tag::all(),
        ];

        return view('pages.articles.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleRequest $request, Article $article)
    {
        try {
            DB::beginTransaction();

            $data = $request->except(['thumbnail', 'tags', 'remove_thumbnail', 'embed']);

            $data['slug'] = Str::slug($request->title);

            $body = $request->input('content');
            $embedHtml = $request->filled('embed') ? $request->input('embed') : '';
            if ($embedHtml) {
                $combined = '<div class="article-wrapper">'
                    . '<div class="article-body">' . $body . '</div>'
                    . '<div class="article-embed">' . $embedHtml . '</div>'
                    . '</div>';
            } else {
                $combined = '<div class="article-wrapper">'
                    . '<div class="article-body">' . $body . '</div>'
                    . '</div>';
            }

            $data['content'] = $combined;

            if ($request->remove_thumbnail == 1) {
                if ($article->thumbnail) {
                    $data['thumbnail'] = null;
                }
            } elseif ($request->hasFile('thumbnail')) {
                $data['thumbnail'] = Storage::put('thumbnails', $request->file('thumbnail'));
            }

            $article->update($data);

            if ($request->filled('tags')) {
                $tagIds = Tag::whereIn('name', $request->tags)->pluck('id')->toArray();
                $article->tags()->sync($tagIds);
            }

            Notification::create([
                'user_id' => Auth::id(),
                'title' => 'Artikel Diperbaharui',
                'message' => 'Artikel ' . $article->title . ' berhasil diperbaharui oleh ' . (Auth::user()->name ?? 'Anonim') . '.',
            ]);

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
    public function destroy(Article $article)
    {
        try {
            DB::beginTransaction();

            Notification::create([
                'user_id' => Auth::id(),
                'title' => 'Artikel Dihapus',
                'message' => 'Artikel ' . $article->title . ' berhasil dihapus oleh ' . (Auth::user()->name ?? 'System') . '.',
            ]);

            $article->delete();

            DB::commit();

            return redirect()
                ->route('articles.index')
                ->with('success', 'Artikel berhasil dihapus.');
        } catch (Throwable $th) {
            DB::rollBack();

            Log::error('Error deleting article: ' . $th->getMessage());

            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menghapus artikel.');
        }
    }

    /**
     * Handle CKEditor image upload
     */
    public function uploadImage(UploadImageRequest $request)
    {
        try {
            $disk = config('filesystems.default');
            $path = Storage::put('contents', $request->file('upload'));

            if ($disk === 'public') {
                $url = asset('storage/' . $path);
            } else {
                $url = route('files', ['path' => $path]);
            }

            return response()->json([
                'url' => $url
            ]);
        } catch (Throwable $th) {
            Log::error('Error uploading image to CKEditor: ' . $th->getMessage());

            return response()->json([
                'error' => 'Terjadi kesalahan saat mengupload gambar.'
            ], 500);
        }
    }

    /**
     * Get paginated articles data for datatable.
     */
    public function datatable(Request $request)
    {
        try {
            $query = Article::with('user', 'category', 'tags');

            // Handle search
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
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

            // Handle sorting
            $sortField = $request->input('sortField', 'created_at');
            $sortOrder = $request->input('sortOrder', 'desc');

            // Handle null or empty values
            if (empty($sortField) || $sortField === 'null') {
                $sortField = 'created_at';
            }

            if (empty($sortOrder) || !in_array(strtolower($sortOrder), ['asc', 'desc'])) {
                $sortOrder = 'desc';
            }

            // Handle sorting based on field type
            if ($sortField === 'user') {
                $query->join('users', 'articles.user_id', '=', 'users.id')
                    ->orderBy('users.name', strtolower($sortOrder))
                    ->select('articles.*');
            } elseif ($sortField === 'category') {
                $query->join('categories', 'articles.category_id', '=', 'categories.id')
                    ->orderBy('categories.name', strtolower($sortOrder))
                    ->select('articles.*');
            } elseif ($sortField === 'tags') {
                $query->leftJoin('article_tag', 'articles.id', '=', 'article_tag.article_id')
                    ->leftJoin('tags', 'article_tag.tag_id', '=', 'tags.id')
                    ->groupBy('articles.id')
                    ->orderByRaw("GROUP_CONCAT(tags.name ORDER BY tags.name SEPARATOR ', ') " . strtolower($sortOrder))
                    ->select('articles.*');
            } else {
                // Direct column sorting for articles table
                $allowedColumns = ['title', 'is_active', 'is_pinned', 'created_at'];
                $sortColumn = in_array($sortField, $allowedColumns) ? $sortField : 'created_at';
                $query->orderBy($sortColumn, strtolower($sortOrder));
            }

            // Get pagination parameters
            $page = $request->input('page', 1);
            $size = $request->input('size', 5);

            // Execute query with pagination
            $articles = $query->paginate($size, ['*'], 'page', $page);

            // Format data for KTUI datatable
            $data = $articles->map(function ($article) {
                return [
                    'id' => $article->id,
                    'title' => $article->title,
                    'category' => $article->category->name,
                    'tags' => $article->tags->pluck('name')->toArray(),
                    'is_active' => $article->is_active,
                    'is_pinned' => $article->is_pinned,
                    'created_at' => $article->created_at->format('d/m/Y H:i'),
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
        } catch (Throwable $th) {
            Log::error('Article datatable error: ' . $th->getMessage());

            return response()->json([
                'error' => 'Terjadi kesalahan saat mengambil data artikel.',
            ], 500);
        }
    }
}
