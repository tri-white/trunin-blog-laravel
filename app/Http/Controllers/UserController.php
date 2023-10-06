<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function profile()
    {
        return view('user/profile');
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
