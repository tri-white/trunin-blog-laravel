<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;

class LikeController extends Controller
{
    public function change(Request $request, $postid, $userid) {
        $like = Like::where('userid', $userid)->where('postid', $postid)->first();
    
        if ($like) {
            $like->delete();
    
            Post::where('id', $postid)->decrement('likes');
        } else {
            $liked = new Like();
            $liked->userid=$userid;
            $liked->postid=$postid;
            $liked->save();
    
            Post::where('id', $postid)->increment('likes');
        }
    
        return redirect()->back();
    }
}
