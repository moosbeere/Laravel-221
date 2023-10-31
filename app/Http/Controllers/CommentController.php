<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Article;
use Illuminate\Support\Facades\Gate;
use App\Jobs\MailJob;


class CommentController extends Controller
{

    public function index(){
        $comments = Comment::latest()->paginate(10);
        $articles = Article::all();
        return view('comment.index', ['comments'=>$comments, 'articles'=>$articles]);
    }

    public function accept(int $id){
        $comment = Comment::findOrFail($id);
        $comment->accept = 1;
        $comment->save();
        return redirect('/comment/all');
    }
    public function reject(int $id){
        $comment = Comment::findOrFail($id);
        $comment->accept = 0;
        $comment->save();
        return redirect('/comment/all');
    }

    public function store(Request $request){
        $request->validate([
            'text'=> 'required'
        ]);
        $article = Article::findOrFail($request->article_id);
        $comment = new Comment;
        $comment->title = $request->title;
        $comment->text = $request->text;
        $comment->article_id = $request->article_id;
        $comment->user_id = auth()->id();
        $res = $comment->save();
        if ($res) MailJob::dispatch($comment, $article->title);
        return redirect()->route('article.show', ['article'=>$request->article_id, 'res'=>$res]);
    }

    public function edit($id){
        $comment = Comment::findOrFail($id);
        Gate::authorize('comment', $comment);
        return view('comment.edit',['comment'=>$comment] );
    }
    public function update(Request $request, $id){
        $request->validate([
            'text'=> 'required'
        ]);

        $comment = Comment::findOrFail($id);
        Gate::authorize('comment', $comment);
        $comment->title = $request->title;
        $comment->text = $request->text;
        $comment->save();
        return redirect()->route('article.show', ['article'=>$request->article_id]);
    }
    public function delete($id){
        
        $comment = Comment::findOrFail($id);
        Gate::authorize('comment', $comment);
        $comment->delete();
        // $comment = NULL;
        return redirect()->route('article.show', ['article'=>$comment->article_id]);
    }
}
