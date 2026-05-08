<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PermissionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_permission_crud_and_datatable_flow(): void
    {
        $this->withoutMiddleware();

        $store = $this->post(route('permissions.store'), [
            'name' => 'permission-test',
            'display_name' => 'Permission Test',
            'description' => 'Permission desc',
        ]);

        $store->assertRedirect(route('permissions.index'));
        $this->assertDatabaseHas('permissions', ['name' => 'permission-test']);

        $permission = Permission::where('name', 'permission-test')->firstOrFail();

        $datatable = $this->getJson(route('permissions.datatable', ['search' => 'permission-test']));
        $datatable->assertOk()->assertJsonStructure(['data', 'page', 'totalPages', 'pageSize', 'totalCount']);

        $delete = $this->delete(route('permissions.destroy', $permission));
        $delete->assertRedirect(route('permissions.index'));
    }
}
