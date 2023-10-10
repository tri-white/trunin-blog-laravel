<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    public function change($userid, $postid){
        $like = Like::where('userid',$userid);
        return false;
    }
}
