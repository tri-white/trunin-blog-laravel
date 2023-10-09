<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function removeUser($userId)
    {
        User::find($userId)->delete();

        return redirect()->route('welcome')->with('success', 'Користувача видалено');
    }
    public function removePost($postId)
    {
        Post::find($postId)->delete();

        return redirect()->route('welcome')->with('success', 'Пост видалено');
    }
    public function removeComment($commentId)
    {
        Comment::find($commentId)->delete();

        return redirect()->route('welcome')->with('success', 'Комментарій видалено');
    }
}
