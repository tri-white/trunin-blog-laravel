<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class User extends Authenticatable
{
    use HasFactory;

    public function get_data($id){
    }
    public function posts()
    {
        return $this->hasMany(Post::class, 'userid');
    }

     public function initiatedFriendships(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id');
    }

    public function receivedFriendships(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'friends', 'friend_id', 'user_id');
    }

    public function mergedFriends()
    {
        return $this->initiatedFriendships->merge($this->receivedFriendships);
    }
    public function friends(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id');
    }
    public function isFriendWith(User $user): bool
    {
        return $this->friends()->where('friend_id', $user->id)->exists();
    }
    public function sentFriendRequests()
    {
        return $this->belongsToMany(User::class, 'friend_requests', 'sender_id', 'receiver_id')
            ->withTimestamps();
    }

    public function hasSentFriendRequestTo(User $user)
    {
        return $this->sentFriendRequests()->where('receiver_id', $user->id)->exists();
    }
    public function receivedFriendRequests()
    {
        return $this->belongsToMany(User::class, 'friend_requests', 'receiver_id', 'sender_id')
            ->withTimestamps();
    }


    public function messages()
    {
    return $this->hasMany(Message::class);
    }

}