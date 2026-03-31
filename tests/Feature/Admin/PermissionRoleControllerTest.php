<?php

namespace Tests\Feature\Admin;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PermissionRoleControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware();
        $role = Role::create([
            'name' => 'role-permission-role-test',
            'display_name' => 'Role Permission Role Test',
            'description' => 'Role for permission-role test',
        ]);
        $user = User::factory()->create();
        $user->addRole($role);
        $this->actingAs($user);
    }

    public function test_permission_role_create_store_datatable_and_destroy(): void
    {
        $permission = Permission::create([
            'name' => 'article-management',
            'display_name' => 'Article Management',
            'description' => 'Manage articles',
        ]);

        $role = Role::create([
            'name' => 'editor-test',
            'display_name' => 'Editor Test',
            'description' => 'Editor role',
        ]);

        $this->get(route('permission-role.index'))->assertOk();
        $this->get(route('permission-role.create'))->assertOk();

        $store = $this->post(route('permission-role.store'), [
            'permission_id' => $permission->id,
            'role_id' => $role->id,
        ]);

        $store->assertRedirect(route('permission-role.index'));
        $this->assertDatabaseHas('permission_role', [
            'permission_id' => $permission->id,
            'role_id' => $role->id,
        ]);

        $datatable = $this->getJson(route('permission-role.datatable', [
            'search' => 'article',
            'sortField' => 'permission_name',
            'sortOrder' => 'asc',
        ]));
        $datatable->assertOk()->assertJsonStructure(['data', 'page', 'totalPages', 'pageSize', 'totalCount']);

        $delete = $this->delete(route('permission-role.destroy', [
            'permission' => $permission->id,
            'role' => $role->id,
        ]));

        $delete->assertRedirect(route('permission-role.index'));
    }
}
