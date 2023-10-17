<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Comment extends Model
{
    use HasFactory;

    // protected $author_id;

    public function article(){
        return $this->belongsTo(Article::class);
    }
    public function user(){
        return $this->belongsTo(User::class, 'author_id');
    }
    public function getAuthor(): User
    {
        Log::alert($this->author_id);
       return User::findOrFail($this->author_id);
    }
}
