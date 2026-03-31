<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class NewPasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_reset_password_screen_can_be_rendered(): void
    {
        $url = URL::temporarySignedRoute('password.reset', now()->addMinutes(10), [
            'token' => 'sample-token',
            'email' => 'user@example.com',
        ]);

        $response = $this->get($url);

        $response->assertOk();
        $response->assertViewIs('pages.auth.reset-password');
        $response->assertViewHas('data', function (array $data): bool {
            return $data['token'] === 'sample-token'
                && $data['email'] === 'user@example.com';
        });
    }

    public function test_password_can_be_reset_with_valid_token(): void
    {
        $user = User::factory()->create([
            'password' => 'OldPassword123!',
        ]);

        $token = Password::createToken($user);

        $response = $this->post(route('password.store'), [
            'token' => $token,
            'email' => $user->email,
            'password' => 'NewPassword123!',
            'password_confirmation' => 'NewPassword123!',
        ]);

        $response->assertRedirect(route('login', absolute: false));
        $response->assertSessionHas('success');
        $this->assertTrue(Hash::check('NewPassword123!', $user->fresh()->password));
    }

    public function test_password_reset_fails_with_invalid_token(): void
    {
        $user = User::factory()->create([
            'password' => 'OldPassword123!',
        ]);

        $response = $this->from(route('password.request'))->post(route('password.store'), [
            'token' => 'invalid-token',
            'email' => $user->email,
            'password' => 'NewPassword123!',
            'password_confirmation' => 'NewPassword123!',
        ]);

        $response->assertRedirect(route('password.request'));
        $response->assertSessionHas('error');
        $this->assertTrue(Hash::check('OldPassword123!', $user->fresh()->password));
    }
}
