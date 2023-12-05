<?php

namespace App\Http\Controllers\API;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Events\EventNewArticle;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentPage = request('page') ? request('page'): 1;
        $article = Cache::remember('articleAll:'.$currentPage, 3000, function(){
           return Article::latest()->paginate(5);
         });
        
         return response()->json(['articles'=>$article]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Gate::authorize('create', [self::class]);
        // return view('article.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('create', [self::class]);

        $request->validate([
            'date' => 'date',
            'title' => 'required|max:20|min:3',
            'text'=>'required|max:255'
        ]);

        $article = new Article;
        $article->date = $request->date;
        $article->title = request('title');
        $article->shortDesc = $request->shortDesc;
        $article->text = $request->text;
        $article->user_id = 1;
        $res = $article->save();
        if ($res) {
            EventNewArticle::dispatch($article);
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>'articleAll:*[0-9]'])->get();
            foreach ($keys as $key){
               Cache::forget($key->key); 
            }
        }
        return response($res);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $currentPage = request('page') ? request('page'): 1;

        if (isset($_GET['notify']))
            auth()->user()->notifications->where('id', $_GET['notify'])->first()->markAsRead();
        
        $comments = Cache::rememberForever('commentAll:article'.$article->id.'/'.$currentPage, function()use($article){
            return Comment::where('article_id', $article->id)
                            ->where('accept', 1)
                            ->latest()->paginate(2);
        });
        
        return response()->json(['article'=>$article, 'comments'=>$comments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        Gate::authorize('create', [self::class]);
        return response()->json(['article'=>$article]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        Gate::authorize('create', [self::class]);

        $request->validate([
            'date' => 'date',
            'title' => 'required|max:20|min:3',
            'text'=>'required|max:255'
        ]);
        $article->date = $request->date;
        $article->title = $request->title;
        $article->shortDesc = $request->shortDesc;
        $article->text = $request->text;
        $article->user_id = 1;
        $res = $article->save();
        if ($res){
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>'articleAll:*[0-9]'])->get();
            foreach ($keys as $key){
               Cache::forget($key->key); 
            }
        }
        return response($res);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        Gate::authorize('create', [self::class]);

        Comment::where('article_id', $article->id)->delete();
        $res = $article->delete();
        if ($res){
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>'articleAll:*[0-9]'])->get();
            foreach ($keys as $key){
               Cache::forget($key->key); 
            }
        }
        return response($res, 201);
    }
}
