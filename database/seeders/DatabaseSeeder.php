<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\ArticleSeeder;
use App\Models\Article;

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
        Article::factory(10)->create();

        // $this->call([
        //     ArticleSeeder::class,
        // ]);
    }


}
