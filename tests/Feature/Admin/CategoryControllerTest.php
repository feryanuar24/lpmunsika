<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware();
        $role = Role::create([
            'name' => 'role-category-test',
            'display_name' => 'Role Category Test',
            'description' => 'Role for category test',
        ]);
        $user = User::factory()->create();
        $user->addRole($role);
        $this->actingAs($user);
    }

    public function test_category_crud_and_datatable_flow(): void
    {
        $store = $this->post(route('categories.store'), [
            'name' => 'Kategori Test',
            'description' => 'Deskripsi kategori',
        ]);

        $store->assertRedirect(route('categories.index'));
        $this->assertDatabaseHas('categories', ['name' => 'Kategori Test', 'slug' => 'kategori-test']);

        $category = Category::where('name', 'Kategori Test')->firstOrFail();

        $datatable = $this->getJson(route('categories.datatable', ['search' => 'Test']));
        $datatable->assertOk()->assertJsonStructure(['data', 'page', 'totalPages', 'pageSize', 'totalCount']);

        $delete = $this->delete(route('categories.destroy', $category));
        $delete->assertRedirect(route('categories.index'));
    }
}
