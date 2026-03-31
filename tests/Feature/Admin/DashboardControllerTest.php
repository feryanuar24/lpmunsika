<?php

namespace Tests\Feature\Admin;

use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_for_user_with_dashboard_permission(): void
    {
        $this->withoutMiddleware();

        $role = Role::create([
            'name' => 'dashboard-admin',
            'display_name' => 'Dashboard Admin',
            'description' => 'dashboard admin role',
        ]);

        $permission = Permission::create([
            'name' => 'dashboard-management',
            'display_name' => 'Dashboard Management',
            'description' => 'manage dashboard',
        ]);

        $role->givePermission($permission);

        $user = User::factory()->create();
        $user->addRole($role);

        $category = Category::create([
            'name' => 'Dashboard Category',
            'slug' => 'dashboard-category',
            'description' => 'category',
        ]);

        $article = Article::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Dashboard Article',
            'slug' => 'dashboard-article',
            'content' => 'content',
            'is_active' => true,
            'is_pinned' => false,
            'views' => 10,
        ]);

        Comment::create([
            'user_id' => $user->id,
            'article_id' => $article->id,
            'content' => 'Komentar dashboard',
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertOk();
        $response->assertViewIs('pages.dashboard.index');
        $response->assertViewHas('data', function (array $data): bool {
            return isset($data['stats']) && isset($data['articles_by_status']) && isset($data['recent_comments']);
        });
    }

    public function test_dashboard_for_regular_user(): void
    {
        $this->withoutMiddleware();

        $role = Role::create([
            'name' => 'dashboard-regular',
            'display_name' => 'Dashboard Regular',
            'description' => 'regular dashboard role',
        ]);

        $user = User::factory()->create();
        $user->addRole($role);

        $category = Category::create([
            'name' => 'Regular Category',
            'slug' => 'regular-category',
            'description' => 'category',
        ]);

        $article = Article::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Regular Article',
            'slug' => 'regular-article',
            'content' => 'content',
            'is_active' => true,
            'is_pinned' => false,
        ]);

        Comment::create([
            'user_id' => $user->id,
            'article_id' => $article->id,
            'content' => 'Komentar user',
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertOk();
        $response->assertViewIs('pages.dashboard.index');
        $response->assertViewHas('data', function (array $data): bool {
            return isset($data['total_comments']) && isset($data['comments']) && isset($data['comments_per_month']);
        });
    }
}
