<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public function author(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function article(){
        return $this->belongsTo(Article::class);
    }

    public function getUserId():User
    {
        return User::findOrFail($this->user_id);
    }
}
