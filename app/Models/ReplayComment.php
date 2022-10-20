<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;

class ReplayComment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function baseComment() {
        return $this->hasOne(Comment::class, 'id', 'comment_id');
    }
}
