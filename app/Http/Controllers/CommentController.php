<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function create(Request $request, $userid, $postid)
    {
        \Log::info("HI world");
        $request->validate([
            'description' => 'required|string|max:255',
        ]);

        $comment = new Comment();
        $comment->userid = $userid;
        $comment->postid = $postid;
        $comment->description = $request->input('description');
        $comment->save();

        return redirect()->route('welcome');
    }

}
