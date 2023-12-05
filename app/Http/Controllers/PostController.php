<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $page = 1;
        $sort = "date-desc";
        $key = "test";
        $cat = "all";

        $query = Post::query();

    
        if ($key != "all") {
            $query->where('description', 'like', '%' . $key . '%')->orWhere('title','like','%'.$key.'%');
        }
    
        if ($cat !== 'all') {
            if($cat=="null") {
                $query->where('category',NULL);
            }
            else{
                $query->where('category', $cat);
            }
        }
    
        if ($sort === 'date-desc') {
            $query->orderByDesc('created_at');
        } elseif ($sort === 'date-asc') {
            $query->orderBy('created_at');
        }elseif ($sort === 'like-desc') {
            $query->orderByDesc('likes');
        } elseif ($sort === 'like-asc') {
            $query->orderBy('likes');
        }
    
        $posts = $query->get();
        
        $postsPerPage = 5;
        $startIndex = ($page - 1) * $postsPerPage;
        $totalPages = ceil($posts->count() / $postsPerPage);
        $currentPagePosts = $posts->slice($startIndex, $postsPerPage);
        $currentPage = $page;
        
        return view('welcome', compact('currentPage', 'totalPages', 'currentPagePosts', 'sort', 'key', 'cat'));

    }
    public function indexe($page, $searchKey, $category, $sort)
    {
        $page = (int)$page;

        $query = Post::query();
    
        if ($searchKey !== "all") {
            $query->where('description', 'like', '%' . $searchKey . '%')->orWhere('title','like','%'.$searchKey.'%');
        }
    
        if ($category !== 'all') {
            if($category==="null") {
                $query->where('category',NULL);
            }
            else{
                $query->where('category', $category);
            }
        }
    
        if ($sort === 'date-desc') {
            $query->orderByDesc('created_at');
        } elseif ($sort === 'date-asc') {
            $query->orderBy('created_at');
        }elseif ($sort === 'like-desc') {
            $query->orderByDesc('likes');
        } elseif ($sort === 'like-asc') {
            $query->orderBy('likes');
        }
    
        $posts = $query->get();
        
        $postsPerPage = 5;
        $startIndex = ($page - 1) * $postsPerPage;
        $totalPages = ceil($posts->count() / $postsPerPage);
        $currentPagePosts= $posts->slice($startIndex, $postsPerPage);
        $currentPage = $page;

        $key = $searchKey;
        $cat = $category;

        return view('welcome', compact('currentPage', 'totalPages', 'currentPagePosts', 'sort', 'key', 'cat'));

    }
    public function create(Request $request)
    {
        $request->validate([
            'post-description' => 'required|string|max:1000',
            'post-category' => 'required|string|max:30',
            'post-title' => 'required|string|max:50',
            'post-photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $post = new Post();
        $post->title = $request->input('post-title');
        $post->description = $request->input('post-description');
        
        if ($request->input('post-category') == "no") {
            $post->category = null;
        } elseif ($request->input('post-category') == "StudyScience") {
            $post->category = "Освіта та наука";
        } elseif ($request->input('post-category') == "Entertainment") {
            $post->category = "Розваги";
        } elseif ($request->input('post-category') == "LifeSport") {
            $post->category = "Життя та спорт";
        }

        $post->userid = Auth::user()->id;

        if ($request->hasFile('post-photo')) {
            $photoPath = $request->file('post-photo')->store('public/postAsk');
            $post->photo_path = $photoPath;
        }
        
        $post->save();

        return redirect()->route('welcome')->with('success', 'Пост успішно створено.');
    }


    public function searchAction(Request $request)
    {
        $key = $request->input('search-input-key');
        $cat = $request->input('post-category-filter');
        $sort = $request->input('post-sort');

        return $this->indexe(1, $key, $cat,$sort);
    }

    public function postDetails($postid){
        $post = Post::where('id', $postid)->first();
        return view('post')->with('post', $post);
    }
    public function edit($postid) {
        $post = Post::find($postid);
        return view('edit-post', ['post' => $post]);
    }
    
    public function update(Request $request, $postid) {
        $request->validate([
            'editedTitle' => 'required|max:255',
            'editedDescription' => 'required|max:1000',
            'editedPhoto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $post = Post::find($postid);
        $post->title = $request->input('editedTitle');
        $post->description = $request->input('editedDescription');
    
        if ($request->hasFile('editedPhoto')) {

            if($post->photo_path != null)
                Storage::delete($post->photo_path);
    
            $photoPath = $request->file('editedPhoto')->store('public/postAsk');
            $post->photo_path = $photoPath;
        }
    
        $post->save();
        
        return redirect()->route('post-details', $postid)->with('success', 'Пост було відредаговано');
    }
}
