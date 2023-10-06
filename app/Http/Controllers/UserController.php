<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function profile()
    {
        return view('profile');
    }
    public function registrationView()
    {
        return view('registration');
    }
    public function loginView()
    {
        return view('login');
    }
    public function logout()
    {
        session()->forget('user_id');

        return redirect()->route('welcome');
    }
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);
        
        $login = $request->input('login');
        $password = $request->input('password');

        $user = User::where('login', $login)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Користувача з таким логіном не знайдено.');
        }

        if (!Hash::check($password, $user->password)) {
            return redirect()->back()->with('error', 'Неправильний пароль.');
        }

        session()->put('user_id', $user->id);

        return redirect()->route('welcome');
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
