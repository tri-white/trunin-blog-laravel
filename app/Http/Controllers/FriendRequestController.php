<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\friendrequest;

class FriendRequestController extends Controller
{
    public function index()
    {
        $friendRequests = Auth::user()->receivedFriendRequests;

        return view('friend_requests', compact('friendRequests'));
    }

    public function accept(Request $request, $requestId)
    {
        $friendRequest = friendrequest::where('sender_id', $requestId)
        ->where('receiver_id', Auth::user()->id)
        ->first();

        if (!$friendRequest) {
            return redirect()->route('friend-requests')->with('error', 'Запит а дружбу не знайдено');
        }

        Auth::user()->friends()->attach($friendRequest->sender_id);
        
        $friendRequest->delete();

        return redirect()->route('friend-requests')->with('success', 'Запит на дружбу прийнято');
    }

    public function decline(Request $request, $requestId)
    {
        $friendRequest = friendrequest::where('sender_id', $requestId)
            ->where('receiver_id', Auth::user()->id)
            ->first();
    
        if (!$friendRequest) {
            return redirect()->route('friend-requests')->with('error', 'Запит а дружбу не знайдено');
        }
    
        $friendRequest->delete();
    
        return redirect()->route('friend-requests')->with('success', 'Запит на дружбу відхилено');
    }
    

    
    
}