<?php

namespace App\Observers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Embed;
use App\Models\Footer;
use App\Models\Menu;
use App\Models\Platform;
use App\Models\Slider;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ContentCacheObserver
{
    public function saved(Model $model): void
    {
        $this->forget($model);
    }

    public function deleted(Model $model): void
    {
        $this->forget($model);
    }

    public function restored(Model $model): void
    {
        $this->forget($model);
    }

    private function forget(Model $model): void
    {
        if ($model instanceof Article || $model instanceof Slider) {
            Cache::forget('public:landing');
            Cache::forget('public:landing:pinned');
            Cache::forget('public:landing:categories');
            Cache::forget('public:landing:sliders');
        }

        if ($model instanceof Category || $model instanceof Tag) {
            Cache::forget('public:navigation');
            Cache::forget('public:landing');
            Cache::forget('public:landing:categories');
        }

        if ($model instanceof Embed || $model instanceof Footer || $model instanceof Platform) {
            Cache::forget('public:navigation');
        }

        if ($model instanceof Menu) {
            Cache::forget('shared:menu-tree');
        }

    }
}
