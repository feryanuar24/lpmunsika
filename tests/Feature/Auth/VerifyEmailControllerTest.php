<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class VerifyEmailControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_can_be_verified_from_valid_signed_url(): void
    {
        Event::fake();

        $user = User::factory()->unverified()->create();

        $url = URL::temporarySignedRoute('verification.verify', now()->addMinutes(10), [
            'id' => $user->getKey(),
            'hash' => sha1($user->getEmailForVerification()),
        ]);

        $response = $this->actingAs($user)->get($url);

        $response->assertRedirect(route('dashboard', absolute: false));
        $response->assertSessionHas('success');
        $this->assertTrue($user->fresh()->hasVerifiedEmail());
        Event::assertDispatched(Verified::class);
    }

    public function test_guest_can_verify_email_from_valid_signed_url(): void
    {
        Event::fake();

        $user = User::factory()->unverified()->create();

        $url = URL::temporarySignedRoute('verification.verify', now()->addMinutes(10), [
            'id' => $user->getKey(),
            'hash' => sha1($user->getEmailForVerification()),
        ]);

        $response = $this->get($url);

        $response->assertRedirect(route('dashboard', absolute: false));
        $response->assertSessionHas('success');
        $this->assertTrue($user->fresh()->hasVerifiedEmail());
        $this->assertAuthenticatedAs($user);
        Event::assertDispatched(Verified::class);
    }

    public function test_already_verified_user_is_redirected_to_dashboard(): void
    {
        $user = User::factory()->create();

        $url = URL::temporarySignedRoute('verification.verify', now()->addMinutes(10), [
            'id' => $user->getKey(),
            'hash' => sha1($user->getEmailForVerification()),
        ]);

        $response = $this->get($url);

        $response->assertRedirect(route('dashboard', absolute: false));
        $response->assertSessionHas('success');
    }

    public function test_email_is_not_verified_with_invalid_hash(): void
    {
        $user = User::factory()->unverified()->create();

        $url = URL::temporarySignedRoute('verification.verify', now()->addMinutes(10), [
            'id' => $user->getKey(),
            'hash' => 'invalid-hash',
        ]);

        $response = $this->get($url);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error');
        $this->assertFalse($user->fresh()->hasVerifiedEmail());
    }

    public function test_email_is_not_verified_with_invalid_signature(): void
    {
        $user = User::factory()->unverified()->create();

        $url = route('verification.verify', [
            'id' => $user->getKey(),
            'hash' => sha1($user->getEmailForVerification()),
        ]);

        $response = $this->get($url);

        $response->assertForbidden();
        $this->assertFalse($user->fresh()->hasVerifiedEmail());
    }
}

