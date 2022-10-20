<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\ReplayComment;

class CommentController extends Controller
{
    public function index()
    {
        $title = 'View Comment';
        $comments = Comment::orderBy('created_at', 'desc')->get();

        return view('admin.comment.index', compact('title', 'comments'));
    }

    public function getReply($id) {
        $title = 'View Comment';
        $responses = ReplayComment::where('comment_id', $id)->orderBy('created_at', 'desc')->get();

        return view('admin.comment.getReply', compact('title', 'responses'));
    }
}
