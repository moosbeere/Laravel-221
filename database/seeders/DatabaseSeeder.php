<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\ArticleSeeder;
use Database\Seeders\RoleSeeder;
use App\Models\Article;
use App\Models\Comment;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Article::factory(10)->has(Comment::factory(3))->create();
        $this->call([
            ArticleSeeder::class,
            RoleSeeder::class,
        ]);

    }
}
