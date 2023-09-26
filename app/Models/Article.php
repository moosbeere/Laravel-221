<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'name',
        'short_desc',
        'desc',
        'authorId'
    ];

    public function comment(){
        return $this->hasMany(Comment::class);
    }
}
