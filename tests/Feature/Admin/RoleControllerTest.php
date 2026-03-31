<?php

namespace Tests\Feature\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware();
        $role = Role::create([
            'name' => 'role-role-test',
            'display_name' => 'Role Role Test',
            'description' => 'Role for role test',
        ]);
        $user = User::factory()->create();
        $user->addRole($role);
        $this->actingAs($user);
    }

    public function test_role_crud_and_datatable_flow(): void
    {
        $store = $this->post(route('roles.store'), [
            'name' => 'role-test',
            'display_name' => 'Role Test',
            'description' => 'Role desc',
        ]);

        $store->assertRedirect(route('roles.index'));
        $this->assertDatabaseHas('roles', ['name' => 'role-test']);

        $role = Role::where('name', 'role-test')->firstOrFail();

        $datatable = $this->getJson(route('roles.datatable', ['search' => 'role-test']));
        $datatable->assertOk()->assertJsonStructure(['data', 'page', 'totalPages', 'pageSize', 'totalCount']);

        $delete = $this->delete(route('roles.destroy', $role));
        $delete->assertRedirect(route('roles.index'));
    }
}
