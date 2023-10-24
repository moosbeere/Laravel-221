<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Article;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminComment;

class CommentController extends Controller
{

    public function index(){
        $comments = Comment::latest()->paginate(10);
        $articles = Article::all();
        return view('comments.index', ['comments'=>$comments, 'articles'=>$articles]);
    }

    public function accept(int $id){
        $comment = Comment::findOrFail($id);
        $comment->accept = true;
        $comment->save();
        return redirect()->route('comments');
    }
    public function reject(int $id){
        $comment = Comment::findOrFail($id);
        $comment->accept = false;
        $comment->save();
        return redirect()->route('comments');
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required',
            'text' => 'required',
            'article_id' => 'required',
        ]);
        $article = Article::findOrFail($request->article_id);
        $comment = new Comment;
        $comment->title = $request->title;
        $comment->text = $request->text;
        $comment->author_id = Auth::id();
        $comment->article_id = $request->article_id;
        $res = $comment->save();
        if ($res) Mail::to('moosbeere_O@mail.ru')->send(new AdminComment($article->name, $comment->text));
        return redirect()->route('article.show', ['article'=>$request->article_id, 'res'=>$res]);
    }

    public function edit($id){
        $comment = Comment::findOrFail($id);
        Gate::authorize('comment', $comment);
        return view('comments.edit', ['comment'=>$comment]);
    }

    public function update($id, Request $request){
        $request->validate([
            'title' => 'required',
            'text' => 'required',
            'article_id' => 'required',
        ]);
        $comment = Comment::findOrFail($id);
        $comment->title = $request->title;
        $comment->text = $request->text;
        $comment->author_id = 1;
        $comment->article_id = $request->article_id;
        $comment->save();
        return redirect()->route('article.show', ['article'=>$request->article_id]);
    }

    public function delete($id){
        $comment = Comment::findOrFail($id);
        $article_id = $comment->article_id;
        Gate::authorize('comment', $comment);
        $comment->delete();
        return redirect()->route('article.show', ['article'=>$article_id]);
    }

}
