<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Chat;
use App\Models\Embed;
use App\Models\Footer;
use App\Models\Platform;
use App\Models\Tag;
use App\Models\Menu;
use App\Models\User;
use App\Models\Article;
use App\Models\Slider;
use App\Observers\ContentCacheObserver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\ViewErrorBag;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        foreach ([Article::class, Category::class, Embed::class, Footer::class, Menu::class, Platform::class, Slider::class, Tag::class] as $model) {
            $model::observe(ContentCacheObserver::class);
        }

        View::composer('*', function ($view) {
            if (!$view->offsetExists('errors')) {
                $view->offsetSet('errors', session()->get('errors') ?? new ViewErrorBag());
            }
        });

        View::composer('*', function ($view) {
            $user = User::find(Auth::id());

            $admin_routes = [
                'dashboard',
                'menus.*',
                'profile',
                'profile.*',
                'users.*',
                'categories.*',
                'tags.*',
                'articles.*',
                'platforms.*',
                'embeds.*',
                'sliders.*',
                'footers.*',
                'permissions.*',
                'roles.*',
                'permission-role.*'
            ];
            $route = Route::currentRouteName() ?? '';

            $matched = false;
            foreach ($admin_routes as $pattern) {
                if (Str::is($pattern, $route)) {
                    $matched = true;
                    break;
                }
            }

            if ($matched) {
                $chats = Chat::latest()->take(10)->get()->sortBy('created_at')->values();
                $menus = Cache::remember('shared:menu-tree', now()->addMinutes(10), fn () => Menu::all());
                $notifications = $user
                    ? $user->notifications()->latest()->take(5)->get()
                    : collect();
                $menu_tree = $this->buildMenuTree($menus);

                $view->with('chats', $chats)
                    ->with('menus', $menu_tree)
                    ->with('notifications', $notifications);
            }
        });

        View::composer('*', function ($view) {
            $public_routes = [
                'landing',
                'tag',
                'detail',
                'category',
                'search'
            ];
            $route = Route::currentRouteName() ?? '';

            $matched = false;
            foreach ($public_routes as $pattern) {
                if (Str::is($pattern, $route)) {
                    $matched = true;
                    break;
                }
            }

            if ($matched) {
                $navigation = Cache::remember('public:navigation', now()->addMinutes(10), function () {
                    return [
                        'youtube' => Embed::whereHas('platform', function ($query) {
                            $query->where('name', 'YouTube');
                        })->latest()->limit(3)->get(),
                        'spotify' => Embed::whereHas('platform', function ($query) {
                            $query->where('name', 'Spotify');
                        })->latest()->limit(3)->get(),
                        'navCategories' => Category::whereNull('parent_id')->with('children')->get(),
                        'categories' => Category::whereNotNull('parent_id')
                            ->orWhereDoesntHave('children')->get(),
                        'tags' => Tag::all(),
                        'footers' => Footer::all(),
                        'platforms' => Platform::all(),
                    ];
                });


                $view
                    ->with('youtube', $navigation['youtube'])
                    ->with('spotify', $navigation['spotify'])
                    ->with('categories', $navigation['categories'])
                    ->with('navCategories', $navigation['navCategories'])
                    ->with('tags', $navigation['tags'])
                    ->with('footers', $navigation['footers'])
                    ->with('platforms', $navigation['platforms']);
            }
        });
    }

    /**
     * Build a nested menu tree from a flat collection of menus.
     *
     * @param \Illuminate\Support\Collection $menus
     * @param int|null $parentId
     * @return array
     */
    private function buildMenuTree($menus, $parentId = null): array
    {
        $branch = [];

        foreach ($menus->where('parent_id', $parentId) as $menu) {
            $children = $this->buildMenuTree($menus, $menu->id);

            $branch[] = [
                'id' => $menu->id,
                'name' => $menu->name,
                'parent_id' => $menu->parent_id,
                'url' => $menu->url,
                'icon' => $menu->icon,
                'permission' => $menu->permission,
                'description' => $menu->description,
                'children' => $children
            ];
        }

        return $branch;
    }
}
