<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    public function profile()
    {
        return view('profile');
    }
    public function registration()
    {
        return view('registration');
        
    }
    public function login()
    {
        return view('login');
        
    }
    public function logout()
    {
        return view('welcome');
    }
    public function register(Request $request)
    {
        $request->validate([
            'login' => 'required|string|max:255',
            'password' => 'required|string|min:8|regex:/[0-9]/',
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
}
