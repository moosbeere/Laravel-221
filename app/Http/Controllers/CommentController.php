<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'title' => 'required',
            'text' => 'required',
            'article_id'=>'required'
        ]);

        $comment = new Comment;
        $comment->title = $request->title;
        $comment->text = $request->text;
        $comment->article_id = $request->article_id;
        $comment->save();
        return redirect()->route('article.show', ['article'=>$comment->article_id]);
    }

    public function edit($id){
        $comment = Comment::findOrFail($id);
        return view('comments.edit', ['comment'=>$comment]);
    }

    public function update($id, Request $request){
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
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return redirect()->route('article.show', ['article'=>$comment->article_id]);
    }
}

