<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
class UserController extends Controller
{
    public function profile($userid)
    {
        $user = User::where('id',$userid)->first();
        return view('user/profile')->with('user',$user);
    }
    public function registrationView()
    {
        return view('user/registration');
    }
    public function loginView()
    {
        return view('user/login');
    }
    public function logout()
    {
        Auth::logout();

        return redirect()->route('welcome');
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = [
            'email' => $request->input('email'), 
            'password' => $request->input('password'),
        ];

        if (Auth::attempt($credentials)) {
            return redirect()->route('welcome');
        }

        return redirect()->back()->with('error', 'Неправильний емейл або пароль.'); 
    }

    public function registration(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users', 
            'password' => 'required|string|min:8',
            'password2' => 'required|string|same:password',
        ]);

        $user = new User();
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->save();

        event(new Registered($user));

        return redirect()->route('login')->with('success', 'Реєстрація успішна. Тепер авторизуйтесь');
    }

    public function editUser(Request $request, $userid)
    {
        $request->validate([
            'editedLogin' => 'required|max:255|unique:users,login,' . $userid,
        ]);

        $user = User::where('id',$userid)->first();

        $user->login = $request->input('editedLogin');
        $user->save();

        return redirect()->back()->with('success', 'Успішно змінено логін');
    }

    public function editUserPhoto(Request $request, $userid)
    {
        $request->validate([
            'editedPhoto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::find($userid);

        $photoPath = $request->file('editedPhoto')->store('public/userAvatars');
        $user->photo = $photoPath;

        $user->save();

        return redirect()->back()->with('success', 'Фотографію успішно завантажено.');
    }

    public function changePassword(Request $request, $userid)
    {
        $request->validate([
            'currentPassword' => 'required|string',
            'newPassword' => 'required|string|min:8',
        ]);

        $user = User::find($userid);

        if (!Hash::check($request->input('currentPassword'), $user->password)) {
            return redirect()->back()->with('error', 'Неправильний пароль!');
        }

        $user->password = bcrypt($request->input('newPassword'));
        $user->save();

        return redirect()->back()->with('success', 'Пароль успішно змінено.');
    }


    public function addFriend(Request $request, $friendId)
    {
        $user = Auth::user();
        $friend = User::find($friendId);

        if (!$user->isFriendWith($friend) && !$user->hasSentFriendRequestTo($friend)) {
            $user->sentFriendRequests()->attach($friendId);

            return redirect()->back()->with('success', 'Запит в друзі успішно надіслано');
        }

        return redirect()->back()->with('error', 'Не вдалося надіслати запит на дружбу');
    }

    public function removeFriend(Request $request, $friendId)
    {
        $user = auth()->user();
        $friend = User::find($friendId);
    
        if ($user->isFriendWith($friend)) {
            $user->friends()->detach($friendId);
    
            return redirect()->back()->with('success', 'Друга успішно видалено');
        }
        if($friend->isFriendWith($user)){
            $friend->friends()->detach($user->id);
    
            return redirect()->back()->with('success', 'Друга успішно видалено');
        }
    
        return redirect()->back()->with('error', 'Не вдалося видалити друга');
    }

    public function viewFriends()
    {
        $initiatedFriendships = auth()->user()->initiatedFriendships;
        $receivedFriendships = auth()->user()->receivedFriendships;
        $friends = $initiatedFriendships->merge($receivedFriendships);

        return view('friends', compact('friends'));
    }

}
