<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $article = Article::latest()->paginate(5);
        return view('article.index', ['articles'=>$article]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('create', [self::class]);
        return view('article.create');
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
        $article->save();
        return redirect()->route('article.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $comments = Comment::where('article_id', $article->id)
                            ->where('accept', 1)
                            ->latest()->get();
        return view('article.show', ['article'=>$article, 'comments'=>$comments]);
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

        return view('article.edit', ['article'=>$article]);
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
        $article->save();
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
        Gate::authorize('create', [self::class]);

        Comment::where('article_id', $article->id)->delete();
        $article->delete();
        return redirect()->route('article.index');
    }
}
