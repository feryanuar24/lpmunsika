<?php

namespace Tests\Feature\Public;

use App\Models\Article;
use App\Models\Category;
use App\Models\Slider;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_page_can_be_rendered(): void
    {
        Slider::create([
            'name' => 'Main Slider',
            'banner' => 'banners/main.jpg',
            'description' => 'Landing banner',
        ]);

        $user = User::factory()->create();

        $berita = Category::create([
            'name' => 'Berita',
            'slug' => 'berita',
            'description' => 'Kategori Berita',
        ]);

        Article::create([
            'user_id' => $user->id,
            'category_id' => $berita->id,
            'title' => 'Pinned Article',
            'slug' => 'pinned-article',
            'content' => 'Pinned content',
            'is_active' => true,
            'is_pinned' => true,
        ]);

        $response = $this->get(route('landing'));

        $response->assertOk();
        $response->assertViewIs('pages.public.landing');
        $response->assertViewHas('data', function (array $data): bool {
            return isset($data['sliders'])
                && isset($data['pinned'])
                && isset($data['categories']);
        });
    }

    public function test_search_returns_matching_active_articles_only(): void
    {
        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Artikel',
            'slug' => 'artikel',
            'description' => 'Kategori Artikel',
        ]);

        $matching = Article::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Laravel Testing Guide',
            'slug' => 'laravel-testing-guide',
            'content' => 'Content about testing',
            'is_active' => true,
        ]);

        Article::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Laravel Hidden Draft',
            'slug' => 'laravel-hidden-draft',
            'content' => 'Should not appear',
            'is_active' => false,
        ]);

        Article::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Another Topic',
            'slug' => 'another-topic',
            'content' => 'No keyword match',
            'is_active' => true,
        ]);

        $response = $this->get(route('search', ['query' => 'Laravel']));

        $response->assertOk();
        $response->assertViewIs('pages.public.search');
        $response->assertViewHas('data', function (array $data) use ($matching): bool {
            $items = $data['articles']->items();

            return $data['query'] === 'Laravel'
                && count($items) === 1
                && $items[0]->id === $matching->id;
        });
    }

    public function test_category_page_lists_only_active_articles(): void
    {
        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Opini',
            'slug' => 'opini',
            'description' => 'Kategori opini',
        ]);

        $activeArticle = Article::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Active Opinion',
            'slug' => 'active-opinion',
            'content' => 'Visible article',
            'is_active' => true,
        ]);

        $inactiveArticle = Article::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Inactive Opinion',
            'slug' => 'inactive-opinion',
            'content' => 'Hidden article',
            'is_active' => false,
        ]);

        $response = $this->get(route('category', $category));

        $response->assertOk();
        $response->assertViewIs('pages.public.category');
        $response->assertViewHas('data', function (array $data) use ($activeArticle, $inactiveArticle): bool {
            $ids = collect($data['articles']->items())->pluck('id');

            return $data['category']->id > 0
                && $ids->contains($activeArticle->id)
                && !$ids->contains($inactiveArticle->id);
        });
    }

    public function test_tag_page_lists_only_active_articles(): void
    {
        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Esai',
            'slug' => 'esai',
            'description' => 'Kategori esai',
        ]);
        $tag = Tag::create([
            'name' => 'Teknologi',
            'slug' => 'teknologi',
            'description' => 'Tag teknologi',
        ]);

        $activeArticle = Article::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Active Tag Article',
            'slug' => 'active-tag-article',
            'content' => 'Visible tagged article',
            'is_active' => true,
        ]);

        $inactiveArticle = Article::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Inactive Tag Article',
            'slug' => 'inactive-tag-article',
            'content' => 'Hidden tagged article',
            'is_active' => false,
        ]);

        $activeArticle->tags()->attach($tag->id);
        $inactiveArticle->tags()->attach($tag->id);

        $response = $this->get(route('tag', $tag));

        $response->assertOk();
        $response->assertViewIs('pages.public.tag');
        $response->assertViewHas('data', function (array $data) use ($activeArticle, $inactiveArticle): bool {
            $ids = collect($data['articles']->items())->pluck('id');

            return $data['tag']->id > 0
                && $ids->contains($activeArticle->id)
                && !$ids->contains($inactiveArticle->id);
        });
    }

    public function test_detail_page_increments_views_and_loads_related_articles(): void
    {
        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Buletin',
            'slug' => 'buletin',
            'description' => 'Kategori buletin',
        ]);

        $article = Article::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Main Detail Article',
            'slug' => 'main-detail-article',
            'content' => 'Main detail content',
            'is_active' => true,
            'views' => 0,
        ]);

        $related = Article::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Related Detail Article',
            'slug' => 'related-detail-article',
            'content' => 'Related content',
            'is_active' => true,
        ]);

        $response = $this->get(route('detail', $article));

        $response->assertOk();
        $response->assertViewIs('pages.public.detail');
        $this->assertSame(1, $article->fresh()->views);
        $response->assertViewHas('data', function (array $data) use ($related): bool {
            return collect($data['related'])->pluck('id')->contains($related->id);
        });
    }

    public function test_like_increments_article_likes(): void
    {
        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Cerpen',
            'slug' => 'cerpen',
            'description' => 'Kategori cerpen',
        ]);

        $article = Article::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Article For Like',
            'slug' => 'article-for-like',
            'content' => 'Likeable content',
            'is_active' => true,
            'likes' => 0,
        ]);

        $response = $this->post(route('like'), [
            'slug' => $article->slug,
        ]);

        $response->assertRedirect(route('detail', $article->slug));
        $response->assertSessionHas('success');
        $this->assertSame(1, $article->fresh()->likes);
    }

    public function test_authenticated_user_can_comment_on_article(): void
    {
        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Review Film',
            'slug' => 'review-film',
            'description' => 'Kategori review film',
        ]);

        $article = Article::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Article For Comment',
            'slug' => 'article-for-comment',
            'content' => 'Commentable content',
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->post(route('comment'), [
            'slug' => $article->slug,
            'content' => 'Great article!',
        ]);

        $response->assertRedirect(route('detail', $article->slug));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('comments', [
            'article_id' => $article->id,
            'user_id' => $user->id,
            'content' => 'Great article!',
            'is_active' => true,
        ]);
    }
}
