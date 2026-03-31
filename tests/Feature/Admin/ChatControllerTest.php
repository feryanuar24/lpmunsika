<?php

namespace Tests\Feature\Admin;

use App\Models\Chat;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChatControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_chat_can_be_stored_and_deleted(): void
    {
        $this->withoutMiddleware();

        $role = Role::create([
            'name' => 'role-chat-test',
            'display_name' => 'Role Chat Test',
            'description' => 'Role for chat test',
        ]);

        $user = User::factory()->create();
        $user->addRole($role);

        $store = $this->actingAs($user)->from(route('landing'))->post(route('chats.store'), [
            'message' => 'Pesan uji coba',
        ]);

        $store->assertRedirect();
        $this->assertDatabaseHas('chats', [
            'user_id' => $user->id,
            'message' => 'Pesan uji coba',
        ]);

        $chat = Chat::where('message', 'Pesan uji coba')->firstOrFail();

        $delete = $this->actingAs($user)->from(route('landing'))->delete(route('chats.destroy', $chat));

        $delete->assertRedirect();
    }
}
