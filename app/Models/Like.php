<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Product,Comment, SubComment};

class Like extends Model
{
    use HasFactory;

    public function products(){
        return $this->morphTo(Product::class, 'likes');
    }

    public function comments(){
        return $this->morphedByMany(Comment::class, 'likable');
    }

    public function subComments(){
        return $this->morphedByMany(SubComment::class, 'likable');
    }
}
