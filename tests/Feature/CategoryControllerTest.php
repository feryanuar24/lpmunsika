<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_crud_and_datatable_flow(): void
    {
        $this->withoutMiddleware();
        
        $store = $this->post(route('categories.store'), [
            'parent_id' => null,
            'name' => 'Kategori Test',
            'description' => 'Deskripsi kategori',
        ]);

        $store->assertRedirect(route('categories.index'));
        $this->assertDatabaseHas('categories', ['parent_id' => null, 'name' => 'Kategori Test', 'slug' => 'kategori-test']);

        $category = Category::where('name', 'Kategori Test')->firstOrFail();

        $datatable = $this->getJson(route('categories.datatable', ['search' => 'Test']));
        $datatable->assertOk()->assertJsonStructure(['data', 'page', 'totalPages', 'pageSize', 'totalCount']);

        $delete = $this->delete(route('categories.destroy', $category));
        $delete->assertRedirect(route('categories.index'));
    }
}
