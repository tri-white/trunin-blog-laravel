<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();

        return view('welcome', compact('posts'));
    }
    public function create(Request $request)
    {
        $request->validate([
            'post-description' => 'nullable|string|max:255',
            'post-category' => 'nullable|string|max:255',
            'post-image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if (!$request->input('post-description') && !$request->hasFile('post-image')) {
            return redirect()->route('welcome')->with('empty-post', 'Потрібно заповнити хоча б одне поле: Текст або Фото');
        }

        $post = new Post();
        $post->description = $request->input('post-description');
        if($request->input('post-category') == "no"){
            $post->category=null;
        }
        else if($request->input('post-category') == "StudyScience"){
            $post->category = "Освіта та наука";
        }
        else if($request->input('post-category') == "Entertainment"){
            $post->category = "Розваги";
        }
        else if($request->input('post-category') == "LifeSport"){
            $post->category = "Життя та спорт";
        }
        $post->userid = Auth::user()->id;

        if ($request->hasFile('post-image')) {
            $imagePath = $request->file('post-image')->store('public/posts');
            $post->photo = $imagePath;
        }

        $post->save();

        return redirect()->route('welcome')->with('success-post', 'Пост успішно створено.');
    }

}
