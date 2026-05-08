<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SitemapControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_sitemap_contains_article_detail_urls(): void
    {
        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Majalah',
            'slug' => 'majalah',
            'description' => 'Kategori majalah',
        ]);

        $firstArticle = Article::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Sitemap First Article',
            'slug' => 'sitemap-first-article',
            'content' => 'First sitemap content',
            'is_active' => true,
        ]);

        $secondArticle = Article::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Sitemap Second Article',
            'slug' => 'sitemap-second-article',
            'content' => 'Second sitemap content',
            'is_active' => true,
        ]);

        $response = $this->get(route('sitemap'));

        $response->assertOk();
        $response->assertSee('/detail/' . $firstArticle->slug, false);
        $response->assertSee('/detail/' . $secondArticle->slug, false);
    }
}
