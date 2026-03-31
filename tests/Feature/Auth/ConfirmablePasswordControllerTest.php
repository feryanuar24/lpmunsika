<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConfirmablePasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_confirm_password_screen_can_be_rendered(): void
    {
        $user = User::factory()->create([
            'password' => 'Password123!',
        ]);

        $response = $this->actingAs($user)->get(route('password.confirm'));

        $response->assertOk();
        $response->assertViewIs('pages.auth.confirm-password');
    }

    public function test_password_can_be_confirmed(): void
    {
        $user = User::factory()->create([
            'password' => 'Password123!',
        ]);

        $response = $this->actingAs($user)->post('/confirm-password', [
            'password' => 'Password123!',
        ]);

        $response->assertRedirect(route('dashboard', absolute: false));
        $response->assertSessionHas('success');
        $response->assertSessionHas('auth.password_confirmed_at');
    }
}
