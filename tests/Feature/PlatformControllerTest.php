<?php

namespace Tests\Feature;

use App\Models\Platform;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlatformControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware();
        $role = Role::create([
            'name' => 'role-platform-test',
            'display_name' => 'Role Platform Test',
            'description' => 'Role for platform test',
        ]);
        $user = User::factory()->create();
        $user->addRole($role);
        $this->actingAs($user);
    }

    public function test_platform_crud_and_datatable_flow(): void
    {
        $store = $this->post(route('platforms.store'), [
            'name' => 'YouTube Test',
            'url' => 'https://youtube.com',
            'icon' => 'ri-youtube-fill',
            'description' => 'Platform video',
        ]);

        $store->assertRedirect(route('platforms.index'));
        $this->assertDatabaseHas('platforms', ['name' => 'YouTube Test']);

        $platform = Platform::where('name', 'YouTube Test')->firstOrFail();

        $datatable = $this->getJson(route('platforms.datatable', ['search' => 'YouTube']));
        $datatable->assertOk()->assertJsonStructure(['data', 'page', 'totalPages', 'pageSize', 'totalCount']);

        $delete = $this->delete(route('platforms.destroy', $platform));
        $delete->assertRedirect(route('platforms.index'));
    }
}
