<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\SubComment;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    public function subComments(){
        return $this->hasMany(SubComment::class);
    }

    public function likes(){
        return $this->morphToMany(Like::class,'likes');
    }
}
