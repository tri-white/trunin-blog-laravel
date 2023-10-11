<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
            'login' => 'required|string',
            'password' => 'required|string',
        ]);
        
        $credentials = [
            'login' => $request->input('login'),
            'password' => $request->input('password'),
        ];
    
        if (Auth::attempt($credentials)) {
            return redirect()->route('welcome');
        }
        return redirect()->back()->with('error', 'Неправильний логін або пароль.');
    }
    public function registration(Request $request)
    {
        $request->validate([
            'login' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'password2' => 'required|string|same:password',
        ]);
        
        $existingUser = User::where('login', $request->input('login'))->first();
        if ($existingUser) {
            return redirect()->back()->with('existing-user', 'Користувач з таким логіном вже існує.');
        }

        $user = new User();
        $user->login = $request->input('login');
        $user->password = bcrypt($request->input('password'));
        $user->save();

        return redirect()->route('login')->with('success', 'Регістрація успішна. Тепер авторизуйтесь');
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
}
