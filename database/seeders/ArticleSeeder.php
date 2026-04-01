<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = [];
        $categories = [1, 3, 4, 6, 7, 8, 9, 10, 11, 12, 13, 14];
        foreach ($categories as $catId) {
            for ($i = 1; $i <= 3; $i++) {
                $articles[] = [
                    'user_id' => 2,
                    'category_id' => $catId,
                    'title' => "Contoh Artikel {$i} Kategori {$catId}",
                    'slug' => "contoh-artikel-{$i}-kategori-{$catId}",
                    'content' => "<p>Ini adalah contoh artikel ke-{$i} untuk kategori {$catId}. Artikel ini dibuat untuk keperluan testing database seeding. Konten ini sengaja dibuat panjang agar dapat digunakan untuk pengujian tampilan dan fitur pada halaman detail artikel.\n</p>\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, urna eu tincidunt consectetur, nisi nisl aliquam nunc, eget aliquam massa nisl quis neque. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse potenti.\n</p>\n<p>Phasellus euismod, justo at commodo mattis, sapien erat facilisis enim, nec cursus erat urna a erat. Proin nec facilisis erat. Etiam euismod, urna eu tincidunt consectetur, nisi nisl aliquam nunc, eget aliquam massa nisl quis neque.\n</p>\n<p>Vivamus euismod, urna eu tincidunt consectetur, nisi nisl aliquam nunc, eget aliquam massa nisl quis neque. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse potenti.\n</p>",
                    'thumbnail' => 'dummy/' . rand(1, 33) . '.jpg',
                    'is_active' => true,
                    'is_pinned' => false,
                    'views' => rand(50, 500),
                    'likes' => rand(5, 50),
                ];
            }
        }

        foreach ($articles as $article) {
            $article = Article::create($article);
            $article->tags()->attach(rand(1, 10));
        }

        Article::find(1)->update(['is_pinned' => true]);
        Article::find(4)->update(['is_pinned' => true]);
        Article::find(7)->update(['is_pinned' => true]);
    }
}
