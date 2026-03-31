<?php

namespace Tests\Feature\Admin;

use App\Models\Embed;
use App\Models\Platform;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmbedControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware();
        $role = Role::create([
            'name' => 'role-embed-test',
            'display_name' => 'Role Embed Test',
            'description' => 'Role for embed test',
        ]);
        $user = User::factory()->create();
        $user->addRole($role);
        $this->actingAs($user);
    }

    public function test_embed_crud_and_datatable_flow(): void
    {
        $platform = Platform::create([
            'name' => 'YouTube',
            'url' => 'https://youtube.com',
            'icon' => 'ri-youtube-fill',
            'description' => 'Youtube platform',
        ]);

        $store = $this->post(route('embeds.store'), [
            'platform_id' => $platform->id,
            'title' => 'Embed Test',
            'embed_code' => '<iframe src="https://youtube.com/embed/test"></iframe>',
            'description' => 'Embed desc',
        ]);

        $store->assertRedirect(route('embeds.index'));
        $this->assertDatabaseHas('embeds', ['title' => 'Embed Test', 'platform_id' => $platform->id]);

        $embed = Embed::where('title', 'Embed Test')->firstOrFail();

        $datatable = $this->getJson(route('embeds.datatable', ['search' => 'Embed Test']));
        $datatable->assertOk()->assertJsonStructure(['data', 'page', 'totalPages', 'pageSize', 'totalCount']);

        $delete = $this->delete(route('embeds.destroy', $embed));
        $delete->assertRedirect(route('embeds.index'));
    }
}
