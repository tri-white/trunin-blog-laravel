<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;
use App\Models\User;
class ChatsController extends Controller
{
    public function indexe()
  {
      $initiatedFriendships = auth()->user()->initiatedFriendships;
      $receivedFriendships = auth()->user()->receivedFriendships;
      $friends = $initiatedFriendships->merge($receivedFriendships);

      $selectedFriendId = request('friend_id');
      
      $selectedFriend = $friends->firstWhere('id', $selectedFriendId);

      $messages = [];

      if ($selectedFriend) {
          $messages = Message::where(function ($query) use ($selectedFriend) {
              $query->where('sender_id', auth()->id())
                  ->where('receiver_id', $selectedFriend->id);
          })->orWhere(function ($query) use ($selectedFriend) {
              $query->where('sender_id', $selectedFriend->id)
                  ->where('receiver_id', auth()->id());
          })->orderBy('created_at')->get();
      }

      return view('private_messages', compact('friends', 'selectedFriendId', 'selectedFriend', 'messages'));
  }

  public function store(User $user)
  {
      $validatedData = request()->validate([
          'message' => 'required|string',
      ]);

      Message::create([
          'sender_id' => auth()->id(),
          'receiver_id' => $user->id,
          'message' => $validatedData['message'],
      ]);

      return redirect()->route('private_messages', ['friend_id' => $user->id]);
  }

  public function fetchMessages($friendId)
    {
        $selectedFriend = User::find($friendId);

        if (!$selectedFriend) {
            return response()->json(['error' => 'Friend not found'], 404);
        }
        $messages = Message::where(function ($query) use ($selectedFriend) {
            $query->where('sender_id', auth()->id())
                ->where('receiver_id', $selectedFriend->id);
        })->orWhere(function ($query) use ($selectedFriend) {
            $query->where('sender_id', $selectedFriend->id)
                ->where('receiver_id', auth()->id());
        })->orderBy('created_at')->get();


         return view('partialsmessages', compact('messages'));
    }
  

}
