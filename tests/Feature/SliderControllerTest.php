<?php

namespace Tests\Feature;

use App\Models\Slider;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SliderControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware();
        $role = Role::create([
            'name' => 'role-slider-test',
            'display_name' => 'Role Slider Test',
            'description' => 'Role for slider test',
        ]);
        $user = User::factory()->create();
        $user->addRole($role);
        $this->actingAs($user);
    }

    public function test_slider_crud_and_datatable_flow(): void
    {
        Storage::fake(config('filesystems.default'));

        $store = $this->post(route('sliders.store'), [
            'name' => 'Slider Test',
            'banner' => UploadedFile::fake()->image('banner.jpg'),
            'description' => 'Slider desc',
        ]);

        $store->assertRedirect(route('sliders.index'));

        $slider = Slider::where('name', 'Slider Test')->firstOrFail();
        $this->assertNotEmpty($slider->banner);

        $datatable = $this->getJson(route('sliders.datatable', ['search' => 'Slider Test']));
        $datatable->assertOk()->assertJsonStructure(['data', 'page', 'totalPages', 'pageSize', 'totalCount']);

        $delete = $this->delete(route('sliders.destroy', $slider));
        $delete->assertRedirect(route('sliders.index'));
    }
}
