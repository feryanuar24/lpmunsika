<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use App\Models\Role;
use App\Models\User;
use App\Notifications\CreateArticleNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Illuminate\Notifications\DatabaseNotification;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware();
        $role = Role::create([
            'name' => 'role-user-test',
            'display_name' => 'Role User Test',
            'description' => 'Role for user test',
        ]);
        $user = User::factory()->create();
        $user->addRole($role);
        $this->actingAs($user);
    }

    public function test_user_crud_datatable_and_notification_actions(): void
    {
        $role = Role::create([
            'name' => 'admin-test',
            'display_name' => 'Admin Test',
            'description' => 'Role admin test',
        ]);

        $store = $this->post(route('users.store'), [
            'name' => 'User Baru',
            'email' => 'userbaru@example.com',
            'roles' => [$role->id],
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $store->assertRedirect(route('users.index'));

        $user = User::where('email', 'userbaru@example.com')->firstOrFail();

        $datatable = $this->getJson(route('users.datatable', ['search' => 'User Baru']));
        $datatable->assertOk()->assertJsonStructure(['data', 'page', 'totalPages', 'pageSize', 'totalCount']);

        $tokenResponse = $this->actingAs($user)->postJson(route('users.save-fcm-token'), [
            'fcm_token' => 'fcm_token_test_123',
        ]);
        $tokenResponse->assertOk()->assertJson(['message' => 'FCM token berhasil disimpan']);

        $category = Category::create([
            'name' => 'Notif Category',
            'slug' => 'notif-category',
            'description' => 'notif',
        ]);

        $article = Article::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Notif Article',
            'slug' => 'notif-article',
            'content' => 'notif content',
            'is_active' => true,
            'is_pinned' => false,
        ]);

        $user->notify(new CreateArticleNotification($article));
        $notificationId = $user->fresh()->notifications()->firstOrFail()->id;

        $readOne = $this->actingAs($user)->post(route('users.read-notification'), [
            'notification_id' => $notificationId,
        ]);
        $readOne->assertRedirect();

        $uuid = (string) Str::uuid();
        DatabaseNotification::create([
            'id' => $uuid,
            'type' => CreateArticleNotification::class,
            'notifiable_type' => User::class,
            'notifiable_id' => $user->id,
            'data' => [
                'title' => 'T',
                'message' => 'M',
                'url' => '/detail/notif-article',
            ],
            'read_at' => null,
        ]);

        $readAll = $this->actingAs($user)->post(route('users.read-all-notifications'));
        $readAll->assertRedirect();

        $delete = $this->actingAs(User::factory()->create())->delete(route('users.destroy', $user));
        $delete->assertRedirect(route('users.index'));
    }
}
