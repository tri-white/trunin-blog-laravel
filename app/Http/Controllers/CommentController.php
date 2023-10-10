<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function create(Request $request, $userid, $postid)
    {
        $request->validate([
            'description' => 'required|string|max:255',
        ]);

        $comment = new Comment();
        $comment->userid = $userid;
        $comment->postid = $postid;
        $comment->description = $request->input('description');
        $comment->save();

        return redirect()->back();
    }

    public function editComment(Request $request, $commentid)
    {
        \Log::info("TEST");
        $request->validate([
            'editedComment' => 'required|string|max:1000',
        ]);

        $comment = Comment::where('id',$commentid);

        $comment->description = $request->input('editedComment');
        $comment->save();

        return redirect()->back()->with('success', 'Коментар було відредаговано');
    }
}
