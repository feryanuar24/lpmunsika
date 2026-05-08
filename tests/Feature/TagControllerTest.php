<?php

namespace Tests\Feature;

use App\Models\Tag;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_tag_crud_and_datatable_flow(): void
    {
        $this->withoutMiddleware();

        $store = $this->post(route('tags.store'), [
            'name' => 'Tag Test',
            'description' => 'Deskripsi tag',
        ]);

        $store->assertRedirect(route('tags.index'));
        $this->assertDatabaseHas('tags', ['name' => 'Tag Test', 'slug' => 'tag-test']);

        $tag = Tag::where('name', 'Tag Test')->firstOrFail();

        $datatable = $this->getJson(route('tags.datatable', ['search' => 'Tag Test']));
        $datatable->assertOk()->assertJsonStructure(['data', 'page', 'totalPages', 'pageSize', 'totalCount']);

        $delete = $this->delete(route('tags.destroy', $tag));
        $delete->assertRedirect(route('tags.index'));
    }
}
