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
    public function edit($commentid) {
        $comment = Comment::find($commentid);
    
        return view('edit-comment', ['comment' => $comment]);
    }
    public function update(Request $request, $commentid) {
        $request->validate([
            'editedComment' => 'required|string|max:1000',
        ]);
        $comment = Comment::find($commentid);

        $comment->description = $request->input('editedComment');
        $comment->save();
    
        return redirect()->route('post-details', $comment->postid)->with('success', 'Коментар було відредаговано');
    }
    
}
