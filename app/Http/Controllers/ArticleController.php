<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(){
        $articles = json_decode(file_get_contents(public_path().'/articles.json'));
        var_dump($articles);
    }
}
