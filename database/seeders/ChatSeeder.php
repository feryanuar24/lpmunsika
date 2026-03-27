<?php

namespace Database\Seeders;

use App\Models\Chat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chats = [
            [
                'user_id' => 1,
                'message' => 'Halo, saya superadmin. Ada yang bisa saya bantu?',
            ],
            [
                'user_id' => 2,
                'message' => 'Halo, saya redaktur. Apakah ada pertanyaan tentang artikel terbaru?',
            ],
            [
                'user_id' => 3,
                'message' => 'Halo, saya general manager. Apakah ada laporan yang perlu saya tinjau?',
            ],
        ];

        foreach ($chats as $chat) {
            Chat::create($chat);
        }
    }
}
