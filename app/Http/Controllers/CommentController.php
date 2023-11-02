<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Jobs\MailJob;
use App\Notifications\NotifyNewArticle;


class CommentController extends Controller
{

    public function index(){
        $comments = Comment::latest()->paginate(10);
        $articles = Article::all();
        return view('comment.index', ['comments'=>$comments, 'articles'=>$articles]);
    }

    public function accept(int $id){
        $comment = Comment::findOrFail($id);
        $article = Article::findOrFail($comment->article_id);
        $users = User::where('id', '!=', $comment->user_id)->get();
        $comment->accept = 1;
        $res = $comment->save();
        if ($res) {
            Notification::send($users, new NotifyNewArticle($article));
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', ['key'=>'commentAll:article*[0-9]/*[0-9]'])->get();
            foreach($keys as $key){
                Cache::forget($key->key);
            }
        }
        
        return redirect('/comment/all');
    }
    public function reject(int $id){
        $comment = Comment::findOrFail($id);
        $comment->accept = 0;
        $res = $comment->save();
        if ($res){
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', ['key'=>'commentAll:article*[0-9]/*[0-9]'])->get();
            foreach($keys as $key){
                Cache::forget($key->key);
            }
        }
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
        if ($res) {
            MailJob::dispatch($comment, $article->title);
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', ['key'=>'commentAll:article*[0-9]/*[0-9]'])->get();
            foreach($keys as $key){
                Cache::forget($key->key);
            }
        }
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
        $res = $comment->save();
        if ($res){
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', ['key'=>'commentAll:article*[0-9]/*[0-9]'])->get();
            foreach($keys as $key){
                Cache::forget($key->key);
            }
        }
        return redirect()->route('article.show', ['article'=>$request->article_id]);
    }
    public function delete($id){
        
        $comment = Comment::findOrFail($id);
        Gate::authorize('comment', $comment);
        $res = $comment->delete();
        if ($res){
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', ['key'=>'commentAll:article*[0-9]/*[0-9]'])->get();
            foreach($keys as $key){
                Cache::forget($key->key);
            }
        }
        // $comment = NULL;
        return redirect()->route('article.show', ['article'=>$comment->article_id]);
    }
}
