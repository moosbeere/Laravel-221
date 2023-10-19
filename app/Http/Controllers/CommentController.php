<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Gate;


class CommentController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'text'=> 'required'
        ]);

        $comment = new Comment;
        $comment->title = $request->title;
        $comment->text = $request->text;
        $comment->article_id = $request->article_id;
        $comment->user_id = auth()->id();
        $comment->save();
        return redirect()->route('article.show', ['article'=>$request->article_id]);
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
