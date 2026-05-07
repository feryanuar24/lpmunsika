<?php

namespace App\Http\Controllers;

use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Article;
use Symfony\Component\HttpFoundation\Response;

class SitemapController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(): Response
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
