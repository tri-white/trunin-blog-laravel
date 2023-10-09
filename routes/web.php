<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [PostController::class, 'index'])->name('welcome');

Route::get('/about', function () {
    return view('about');
})->name('about');


Route::get('/registration', [UserController::class, 'registrationView'])->name('registrationView');
Route::post('/registration', [UserController::class, 'registration'])->name('registration');

Route::get('/login', [UserController::class, 'loginView'])->name('loginView');
Route::post('/login', [UserController::class, 'login'])->name('login');

Route::get('/profile/{userid}', [UserController::class, 'profile'])->name('profile');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');


Route::post('/', [PostController::class, 'create'])->name('create-post');

Route::post('/comment/{userid}/{postid}', [CommentController::class, 'create'])->name('add-comment');




