<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_pages_and_update_destroy_flow(): void
    {
        $role = Role::create([
            'name' => 'role-profile-test',
            'display_name' => 'Role Profile Test',
            'description' => 'Role for profile test',
        ]);

        $user = User::factory()->create([
            'password' => 'Password123!',
            'email_verified_at' => now(),
        ]);
        $user->addRole($role);

        $update = $this->actingAs($user)->patch('/profile', [
            'name' => 'Nama Baru',
            'email' => 'baru@example.com',
            'password' => 'NewPassword123!',
            'password_confirmation' => 'NewPassword123!',
        ]);

        $update->assertRedirect(route('profile'));
        $user->refresh();

        $this->assertSame('Nama Baru', $user->name);
        $this->assertSame('baru@example.com', $user->email);
        $this->assertNull($user->email_verified_at);
        $this->assertTrue(Hash::check('NewPassword123!', $user->password));
    }
}
