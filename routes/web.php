<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AdminController;
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

Route::get('/about', function () {
    return view('about');
})->name('about');


Route::get('/registration', [UserController::class, 'registrationView'])->name('registrationView');
Route::post('/registration', [UserController::class, 'registration'])->name('registration');
Route::get('/login', [UserController::class, 'loginView'])->name('loginView');
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::get('/profile/{userid}', [UserController::class, 'profile'])->name('profile');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/', [PostController::class, 'index'])->name('welcome');
Route::get('/search', [PostController::class, 'searchAction'])->name('post-search');
Route::post('/', [PostController::class, 'create'])->name('create-post');
Route::get('/post/{postid}', [PostController::class, 'postDetails'])->name('post-details');

Route::post('/comment/{userid}/{postid}', [CommentController::class, 'create'])->name('add-comment');

Route::post('/removeuser/{userid}', [AdminController::class, 'removeUser'])->name('remove-user');
Route::post('/removepost/{postid}', [AdminController::class, 'removePost'])->name('remove-post');
Route::post('/removecomment/{commentid}', [AdminController::class, 'removeComment'])->name('remove-comment');






