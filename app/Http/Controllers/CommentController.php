<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'title' => 'required',
            'text' => 'required',
            'article_id' => 'required',
        ]);
        $comment = new Comment;
        $comment->title = $request->title;
        $comment->text = $request->text;
        $comment->author_id = Auth::id();
        $comment->article_id = $request->article_id;
        $comment->save();
        return redirect()->route('article.show', ['article'=>$request->article_id]);
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
