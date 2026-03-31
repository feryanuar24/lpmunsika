<?php

namespace Tests\Feature\Admin;

use App\Models\Menu;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware();
        $role = Role::create([
            'name' => 'role-menu-test',
            'display_name' => 'Role Menu Test',
            'description' => 'Role for menu test',
        ]);
        $user = User::factory()->create();
        $user->addRole($role);
        $this->actingAs($user);
    }

    public function test_menu_index_and_datatable(): void
    {
        $parent = Menu::create([
            'name' => 'Parent Menu',
            'url' => '/parent',
            'icon' => 'ri-home-line',
            'permission' => 'dashboard-management',
            'description' => 'Parent',
        ]);

        Menu::create([
            'parent_id' => $parent->id,
            'name' => 'Child Menu',
            'url' => '/child',
            'icon' => 'ri-file-list-line',
            'permission' => 'dashboard-management',
            'description' => 'Child',
        ]);

        $datatable = $this->getJson(route('menus.datatable', ['search' => 'Child']));
        $datatable->assertOk()->assertJsonStructure(['data', 'page', 'totalPages', 'pageSize', 'totalCount']);
    }
}
