<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Article;


class SitemapController extends Controller
{
    public function __invoke()
    {
        $sitemap = Sitemap::create();

        $articles = Article::latest()->get();

        foreach ($articles as $article) {
            $sitemap->add(
                Url::create("/detail/{$article->slug}")
                    ->setLastModificationDate($article->updated_at)
            );
        }

        return $sitemap->toResponse(request());
    }
}
