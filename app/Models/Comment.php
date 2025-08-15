<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];
    public function posts(){
        return $this->belongsTo(Post::class,'postid','id');
    }
    public function users(){
        return $this->belongsTo(User::class,'userid','id');
    }
    
}
