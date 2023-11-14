<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Jobs\ArticleMailJob;
use App\Events\EventNewComment;



class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = isset($_GET['page']) ? $_GET['page']: 0;
        $articles = Cache::remember('articles'.$page, 3000, function(){
            return Article::latest()->paginate(5);
        });
        return view('articles.main', ['articles'=>$articles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('create', [self::class]);
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'shortDesc' => 'required|min:5'
        ]);
        $article = new Article;
        $article->date = $request->date;
        $article->name = $request->title;
        $article->short_desc = $request->shortDesc;
        $article->desc = $request->desc;
        $article->author_id = 1;
        $res = $article->save();
        if ($res){
            ArticleMailJob::dispatch($article);
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>'articles*[0-9]'])->get();
            foreach($keys as $key){
                Cache::forget($key->key);
            }            
        }
        return redirect('/article');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        if (isset($_GET['notify'])){
            auth()->user()->notifications->where('id', $_GET['notify'])->first()->markAsRead();
        }
        $page = isset($_GET['page']) ? ($_GET['page']) : 0;
        $comments = Cache::rememberForever($article->id.'/comments'.$page,function()use($article){
            return Comment::where('article_id', $article->id)
                            ->where('accept', 1)
                            ->latest()->paginate(2);
        });
        
        return view('articles.show', ['article'=>$article, 'comments'=>$comments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        Gate::authorize('update', [self::class, $article]);
        return view('articles.edit', ['article'=>$article]);
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
        $request->validate([
            'title' => 'required',
            'shortDesc' => 'required|min:5'
        ]);
        $article->date = $request->date;
        $article->name = $request->title;
        $article->short_desc = $request->shortDesc;
        $article->desc = $request->desc;
        $article->author_id = 1;
        $res = $article->save();
        if ($res){
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>$article->id.'/comments*[0-9]'])->get();
            foreach($keys as $key){
                Cache::forget($key->key);
            }
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>'articles*[0-9]'])->get();
            foreach($keys as $key){
                Cache::forget($key->key);
            }
        }
        return redirect()->route('article.show', ['article'=>$article]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        Gate::authorize('delete', [self::class, $article]);
        $comments = Comment::where('article_id', $article->id)->delete();
        $res = $article->delete();
        if ($res){
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>$article->id.'/comments*[0-9]'])->get();
            foreach($keys as $key){
                Cache::forget($key->key);
            }
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>'articles*[0-9]'])->get();
            foreach($keys as $key){
                Cache::forget($key->key);
            }
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>'comments*[0-9]'])->get();
            foreach($keys as $key){
                Cache::forget($key->key);
            }
        }
        return redirect('/article');
    }
}
