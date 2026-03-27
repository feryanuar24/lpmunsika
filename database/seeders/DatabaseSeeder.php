<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            PermissionRoleSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            TagSeeder::class,
            ArticleSeeder::class,
            CommentSeeder::class,
            PlatformSeeder::class,
            EmbedSeeder::class,
            ChatSeeder::class,
            FooterSeeder::class,
            MenuSeeder::class,
            SliderSeeder::class,
        ]);
    }
}
