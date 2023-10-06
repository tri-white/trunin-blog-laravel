<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'post-description' => 'nullable|string|max:255',
            'post-category' => 'nullable|string|max:255',
            'post-image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if (!$request->input('post-description') && !$request->hasFile('post-image')) {
            return view('welcome')->with('empty-post', 'Потрібно заповнити хоча б одне поле: Текст або Фото');
        }

        $post = new Post();
        $post->description = $request->input('post-description');
        $post->category = $request->input('post-category');

        // Handle image upload, if provided
        if ($request->hasFile('post-image')) {
            $imagePath = $request->file('post-image')->store('posts'); // Adjust the storage path as needed
            $post->image = $imagePath;
        }

        $post->save();

        return view('welcome')->with('success-post', 'Пост успішно створено.');
    }

}
