<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Like;

class AdminController extends Controller
{
    public function removeUser(Request $request, $userId)
    {
        Comment::where('userid', $userId)->delete();
        Post::where('userid', $userId)->delete();
        User::find($userId)->delete();
        return redirect()->route('welcome', ['page'=>1, 'searchKey'=>'all','category'=>'all','sort'=>'date-desc'])->with('success', 'Користувача видалено');
    }

    public function removePost(Request $request, $postId)
    {
        Comment::where('postid', $postId)->delete();
        Like::where('postid',$postId)->delete();
        Post::find($postId)->delete();
        return redirect()->route('welcome', ['page'=>1, 'searchKey'=>'all','category'=>'all','sort'=>'date-desc'])->with('success', 'Пост видалено');
    }

    public function removeComment(Request $request, $commentId)
    {
        Comment::find($commentId)->delete();

        return redirect()->route('welcome', ['page'=>1, 'searchKey'=>'all','category'=>'all','sort'=>'date-desc'])->with('success', 'Комментарій видалено');
    }
}
