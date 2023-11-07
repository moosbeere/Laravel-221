<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminComment;
use App\Notifications\NotifyNewComment;
use App\Events\EventNewComment;

class CommentController extends Controller
{

    public function index(){
        $comments = Comment::latest()->paginate(10);
        $articles = Article::all();
        return view('comments.index', ['comments'=>$comments, 'articles'=>$articles]);
    }

    public function accept(int $id){
        Gate::authorize('admincomment');
        $comment = Comment::findOrFail($id);
        $article = Article::findOrFail($comment->article_id);
        $comment->accept = true;
        $res = $comment->save();
        if ($res) EventNewComment::dispatch($article);
        return redirect()->route('comments');
    }
    public function reject(int $id){
        Gate::authorize('admincomment');
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
        $users = User::where('id', '!=', auth()->id())->get();
        $comment = new Comment;
        $comment->title = $request->title;
        $comment->text = $request->text;
        $comment->author_id = Auth::id();
        $comment->article_id = $request->article_id;
        $res = $comment->save();
        if ($res) {
            Mail::to('moosbeere_O@mail.ru')->send(new AdminComment($article->name, $comment->text));
            // $users->notify(new NotifyNewComment($article->name)); //вызывает ошибку, так как нельзя отправить от массива объектов
            Notification::send($users, new NotifyNewComment($article));
        }
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
