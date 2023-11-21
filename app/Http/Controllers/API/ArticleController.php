<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Jobs\MailJob;
use App\Events\ArticleCreateEvent;


class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentPage = request('page') ? request('page') : 1;
        $articles = Cache::remember('articleAll'.$currentPage, 3000, function(){
             return Article::latest()->paginate(5);
        });
        
        return response()->json(['articles'=>$articles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Gate::authorize('create', [self::class]);
        // return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $caches = DB::table('cache')->whereRaw('`key` GLOB :key',  [':key'=> 'articleAll*[0-9]'])->get();
        foreach($caches as $cache){
            Cache::forget($cache->key);
        }
        
        $request->validate([
            'title'=>'required',
            'shortDesc'=>'required|min:5'
        ]);
        $article = new Article;
        $article->date = $request->date;
        $article->name = $request->title;
        $article->short_desc = $request->shortDesc;
        $article->desc = $request->desc;
        $article->author_id = 1;
        $article->save();
        MailJob::dispatch($article);
        ArticleCreateEvent::dispatch($article);
        return response()->json(['article'=>$article]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $currentPage = request('page') ? request('page') : 1;
        if(isset($_GET['notify'])) {
            auth()->user()->notifications->where('id', $_GET['notify'])->first()->markAsRead();
        }
        $comments = Cache::remember('article/'.$article->id.':'.$currentPage, 3000, function()use($article){
            return Comment::where('article_id', $article->id)
                             ->where('accept', true)
                             ->latest()->paginate(2);
        });
        return response()->json(['article' => $article, 'comments'=>$comments]);
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
        return response()->json(['article' => $article]);
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
        $caches = DB::table('cache')->whereRaw('`key` GLOB :key',  [':key'=> 'articleAll*[0-9]'])->get();
        foreach($caches as $cache){
            Cache::forget($cache->key);
        }

        Gate::authorize('create', [self::class]);
        $request->validate([
            'title'=>'required',
            'shortDesc'=>'required|min:5'
        ]);

        $article->date = $request->date;
        $article->name = $request->title;
        $article->short_desc = $request->shortDesc;
        $article->desc = $request->desc;
        $article->author_id = 1;
        $article->save();
        return response()->json(['article'=>$article]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $caches = DB::table('cache')->whereRaw('`key` GLOB :key',  [':key'=> 'articleAll*[0-9]'])->get();
        foreach($caches as $cache){
            Cache::forget($cache->key);
        }
        
        Gate::authorize('create', [self::class]);
        Comment::where('article_id', $article->id)->delete();
        $res = $article->delete();
        return response($res);
    }
}
