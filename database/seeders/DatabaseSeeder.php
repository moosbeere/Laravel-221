<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\ArticleSeeder;
use App\Models\Article;
use App\Models\Comment;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            // ArticleSeeder::class,
            UserSeeder::class,
        ]);

        // \App\Models\User::factory(10)->create();
        // Article::factory(10)->has(Comment::factory(3)->forAuthor([
        //     'name'=>'olga'
        // ]))->create();
            Article::factory(10)->has(Comment::factory(3))->create();
    }


}
