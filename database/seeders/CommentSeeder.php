<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $comments = [
            [
                'article_id' => 1,
                'user_id' => 4,
                'content' => 'Komentar pertama untuk artikel 1',
                'is_active' => true,
            ],
            [
                'article_id' => 1,
                'user_id' => 4,
                'content' => 'Komentar kedua untuk artikel 1',
                'is_active' => true,
            ],
            [
                'article_id' => 2,
                'user_id' => 4,
                'content' => 'Komentar pertama untuk artikel 2',
                'is_active' => true,
            ],
            [
                'article_id' => 3,
                'user_id' => 4,
                'content' => 'Komentar pertama untuk artikel 3',
                'is_active' => true,
            ],
        ];

        foreach ($comments as $comment) {
            Comment::create($comment);
        }
    }
}
