<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Role;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware();
    }

    public function test_article_flow_including_store_update_datatable_upload_and_delete_comment(): void
    {
        Notification::fake();
        Storage::fake(config('filesystems.default'));

        $role = Role::create([
            'name' => 'role-article-test',
            'display_name' => 'Role Article Test',
            'description' => 'Role for article test',
        ]);

        $user = User::factory()->create();
        $user->addRole($role);
        $this->actingAs($user);

        $category = Category::create([
            'name' => 'Artikel Admin',
            'slug' => 'artikel-admin',
            'description' => 'Kategori artikel',
        ]);

        $tag = Tag::create([
            'name' => 'Tag Admin',
            'slug' => 'tag-admin',
            'description' => 'Tag artikel',
        ]);

        $store = $this->post(route('articles.store'), [
            'title' => 'Artikel Baru Admin',
            'category_id' => $category->id,
            'tags' => [$tag->id],
            'content' => 'Konten artikel admin',
            'embed' => '<iframe src="https://example.com/embed"></iframe>',
            'thumbnail' => UploadedFile::fake()->image('thumb.jpg'),
            'is_active' => true,
            'is_pinned' => false,
        ]);

        $store->assertRedirect(route('articles.index'));

        $article = Article::where('title', 'Artikel Baru Admin')->firstOrFail();

        $datatable = $this->getJson(route('articles.datatable', ['search' => 'Artikel Baru Admin']));
        $datatable->assertOk()->assertJsonStructure(['data', 'page', 'totalPages', 'pageSize', 'totalCount']);

        $upload = $this->post(route('articles.upload-image'), [
            'upload' => UploadedFile::fake()->image('content.jpg'),
        ]);
        $upload->assertOk()->assertJsonStructure(['url']);

        $comment = Comment::create([
            'user_id' => $user->id,
            'article_id' => $article->id,
            'content' => 'Komentar untuk dihapus',
            'is_active' => true,
        ]);

        $deleteComment = $this->delete(route('articles.delete-comment', $comment));
        $deleteComment->assertRedirect();

        $deleteArticle = $this->delete(route('articles.destroy', $article));
        $deleteArticle->assertRedirect();
    }
}
