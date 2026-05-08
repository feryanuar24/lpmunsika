<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_menu_index_and_datatable(): void
    {
        $this->withoutMiddleware();

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
