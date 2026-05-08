<?php

namespace Tests\Feature;

use App\Models\Footer;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FooterControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_footer_crud_and_datatable_flow(): void
    {
        $this->withoutMiddleware();

        $store = $this->post(route('footers.store'), [
            'name' => 'Footer Test',
            'url' => 'https://example.com/footer',
            'description' => 'Footer desc',
        ]);

        $store->assertRedirect(route('footers.index'));
        $this->assertDatabaseHas('footers', ['name' => 'Footer Test']);

        $footer = Footer::where('name', 'Footer Test')->firstOrFail();

        $datatable = $this->getJson(route('footers.datatable', ['search' => 'Footer Test']));
        $datatable->assertOk()->assertJsonStructure(['data', 'page', 'totalPages', 'pageSize', 'totalCount']);

        $delete = $this->delete(route('footers.destroy', $footer));
        $delete->assertRedirect(route('footers.index'));
    }
}
