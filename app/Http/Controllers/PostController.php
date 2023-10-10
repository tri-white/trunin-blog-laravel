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
            'post-description' => 'required|string|max:255',
            'post-category' => 'required|string|max:255',
            'post-title' => 'required|string|max:50',
        ]);
        
        $post = new Post();
        $post->title = $request->input('post-title');
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

    public function postDetails($postid){
        $post = Post::where('id', $postid)->first();
        return view('post')->with('post', $post);
    }

    public function search($key, $cat, $sort)
    {
        $query = Post::query();

        if ($key != "") {
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
        } elseif ($sort === 'comm-asc') {

        } elseif ($sort === 'like-desc') {
            $query->orderByDesc('likes');
        } elseif ($sort === 'like-asc') {
            $query->orderBy('likes');

        }
        

        $posts = $query->get();

        return $posts;
    }

}
