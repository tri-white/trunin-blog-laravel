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
        $sort = "date-asc";
        $key = "";
        $cat = "all";
        $posts = $this->search($key,$cat,$sort);

        return view('welcome', compact('posts', 'sort', 'key', 'cat'));

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

        return redirect()->route('welcome')->with('success', 'Пост успішно створено.');
    }

    public function searchAction(Request $request)
    {
        $key = $request->input('search-input-key');
        $cat = $request->input('post-category-filter');
        $sort = $request->input('post-sort');

        $posts = $this->search($key,$cat,$sort);

        return redirect()->view('welcome', compact('posts', 'key', 'cat', 'sort'));
    }
    public function search($key, $cat, $sort)
    {
        $query = Post::query();

        if ($key) {
            $query->where('description', 'like', '%' . $key . '%');
        }

        if ($cat !== 'all') {
            $query->where('category', $cat);
        }

        if ($sort === 'date-desc') {
            $query->orderByDesc('created_at');
        } elseif ($sort === 'date-asc') {
            $query->orderBy('created_at');
        } elseif ($sort === 'comm-desc') {
            // You can add sorting logic based on comments count here
        } elseif ($sort === 'comm-asc') {
            // You can add sorting logic based on comments count here
        }

        $posts = $query->get();

        return $posts;
    }

}
