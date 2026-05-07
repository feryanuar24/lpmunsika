<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __invoke(): View
    {
        $user = User::find(Auth::id());

        if ($user->hasPermission('dashboard-management')) {
            $data = [
                'stats' => [
                    'total_users' => User::count(),
                    'total_articles' => Article::count(),
                    'total_views' => Article::sum('views'),
                ],

                'articles_by_status' => [
                    'published' => Article::where('is_active', true)->count(),
                    'draft' => Article::where('is_active', false)->count(),
                ],

                'articles_by_category' => Category::whereNotNull('parent_id')->orWhereDoesntHave('children')->withCount('articles')
                    ->orderBy('articles_count', 'desc')
                    ->get()
                    ->map(function ($category) {
                        return [
                            'name' => $category->name,
                            'count' => $category->articles_count
                        ];
                    }),

                'user_registration_trend' => User::select(
                    DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                    DB::raw('COUNT(*) as count')
                )
                    ->where('created_at', '>=', Carbon::now()->subMonths(12))
                    ->groupBy('month')
                    ->orderBy('month')
                    ->get()
                    ->map(function ($item) {
                        $date = Carbon::createFromFormat('Y-m', $item->month);
                        return [
                            'month' => $date->translatedFormat('m') . ' ' . $date->translatedFormat('Y'),
                            'count' => $item->count
                        ];
                    }),

                'article_publishing_trend' => Article::select(
                    DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                    DB::raw('COUNT(*) as count')
                )
                    ->where('created_at', '>=', Carbon::now()->subMonths(12))
                    ->groupBy('month')
                    ->orderBy('month')
                    ->get()
                    ->map(function ($item) {
                        $date = Carbon::createFromFormat('Y-m', $item->month);
                        return [
                            'month' => $date->translatedFormat('m') . ' ' . $date->translatedFormat('Y'),
                            'count' => $item->count
                        ];
                    }),

                'most_viewed_articles' => Article::orderBy('views', 'desc')
                    ->limit(5)
                    ->get()
                    ->map(function ($article) {
                        return [
                            'id' => $article->id,
                            'title' => $article->title,
                            'views' => $article->views,
                            'category' => $article->category->name
                        ];
                    }),

                'views_distribution' => [
                    'low' => Article::where('views', '<', 100)->count(),
                    'medium' => Article::whereBetween('views', [100, 1000])->count(),
                    'high' => Article::where('views', '>', 1000)->count(),
                ],

                'recent_comments' => Comment::with(['article', 'user'])
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get(),
            ];
        } else {
            $data = [
                'total_comments' => Comment::where('user_id', $user->id)->count(),
                'total_articles' => Comment::where('user_id', $user->id)->pluck('article_id')->unique()->count(),
                'comments' => Comment::where('user_id', $user->id)
                    ->with('article')
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get(),
                'comments_per_month' => Comment::select(
                    DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                    DB::raw('COUNT(*) as count')
                )
                    ->where('user_id', $user->id)
                    ->where('created_at', '>=', Carbon::now()->subMonths(12))
                    ->groupBy('month')
                    ->orderBy('month')
                    ->get()
                    ->map(function ($item) {
                        $date = Carbon::createFromFormat('Y-m', $item->month);
                        return [
                            'month' => $date->translatedFormat('m') . ' ' . $date->translatedFormat('Y'),
                            'count' => $item->count
                        ];
                    }),
            ];
        }

        return view('pages.dashboard.index', compact('data'));
    }
}
