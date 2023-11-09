<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
use App\Mail\AdminComment;
use App\Models\Article;
use App\Models\User;
use App\Notifications\CommentNotifi;



class CommentController extends Controller
{

    public function index(){
        $comments = Comment::latest()->paginate(10);
        return view('comments.index', ['comments'=>$comments]);
    }

    public function accept(int $id){ 
        
        $comment = Comment::findOrFail($id);
        $users = User::where('id', '!=', $comment->author_id)->get();
        $article = Article::findOrFail($comment->article_id);

        $caches = DB::table('cache')->whereRaw('`key` GLOB :key',  [':key'=> 'article/*[0-9]:[0-9]'])->get();
        foreach($caches as $cache){
            Cache::forget($cache->key);
        }

        $comment->accept = true;
        $comment->save();
        Notification::send($users, new CommentNotifi($article));
        return redirect('/comment');
    }

    public function reject(int $id){

        $caches = DB::table('cache')->whereRaw('`key` GLOB :key',  [':key'=> 'article/*[0-9]:[0-9]'])->get();
        foreach($caches as $cache){
            Cache::forget($cache->key);
        }

        $comment = Comment::findOrFail($id);
        $comment->accept = false;
        $comment->save();
        return redirect('/comment');
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required',
            'text' => 'required',
            'article_id'=>'required'
        ]);
        $article = Article::findOrFail($request->article_id);
        $comment = new Comment;
        $comment->title = $request->title;
        $comment->text = $request->text;
        $comment->article_id = $request->article_id;
        // $comment->author_id = Auth::id();
        $comment->user()->associate(auth()->user());
        $res = $comment->save();
        if($res) {
            // Mail::to('moosbeere_O@mail.ru')->send(new AdminComment($comment, $article->name));
        }
        return redirect()->route('article.show', ['article'=>$comment->article_id, 'res'=>$res]);
    }

    public function edit($id){
        $comment = Comment::findOrFail($id);
        Gate::authorize('comment', $comment);
        return view('comments.edit', ['comment'=>$comment]);
    }

    public function update($id, Request $request){
        $caches = DB::table('cache')->whereRaw('`key` GLOB :key',  [':key'=> 'article/*[0-9]:[0-9]'])->get();
        foreach($caches as $cache){
            Cache::forget($cache->key);
        }
        $request->validate([
            'title' => 'required',
            'text' => 'required',
        ]);
        $comment = Comment::findOrFail($id);
        $comment->title = $request->title;
        $comment->text = $request->text;
        $comment->article_id = $comment->article_id;
        $comment->save();
        return redirect()->route('article.show', ['article'=>$comment->article_id]);
    }

    public function delete($id){

        $caches = DB::table('cache')->whereRaw('`key` GLOB :key',  [':key'=> 'article/*[0-9]:[0-9]'])->get();
        foreach($caches as $cache){
            Cache::forget($cache->key);
        }
        
        $comment = Comment::findOrFail($id);
        Gate::authorize('comment', $comment);
        $comment->delete();
        return redirect()->route('article.show', ['article'=>$comment->article_id]);
    }
}

