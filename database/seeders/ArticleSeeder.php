<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $articles = json_decode(file_get_contents(public_path().'/articles.json'));
        foreach($articles as $article){
            Article::create([
                'date' => $article->date,
                'title' => $article->name,
                'shortDesc' => $article->shortDesc,
                'text' => $article->desc,
                'user_id' => 1
            ]);
        }
    }
}
