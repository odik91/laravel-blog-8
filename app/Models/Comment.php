<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function postComment() {
        return $this->hasOne(Post::class, 'id', 'post_id');
    }
}
