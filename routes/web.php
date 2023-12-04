<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FriendRequestController;


Route::get('/about', function () {
    return view('about');
})->name('about');


Route::get('/registration', [UserController::class, 'registrationView'])->name('registrationView');
Route::post('/registration', [UserController::class, 'registration'])->name('registration');
Route::get('/login', [UserController::class, 'loginView'])->name('loginView');
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::get('/profile/{userid}', [UserController::class, 'profile'])->name('profile');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');
Route::post('/profile/edit/{userid}', [UserController::class, 'editUser'])->name('edit-user');


Route::post('/removeuser/{userid}', [AdminController::class, 'removeUser'])->name('remove-user');
Route::post('/removepost/{postid}', [AdminController::class, 'removePost'])->name('remove-post');
Route::post('/removecomment/{commentid}', [AdminController::class, 'removeComment'])->name('remove-comment');

Route::get('/', [PostController::class, 'index'])->name('welcome');
Route::get('/search', [PostController::class, 'searchAction'])->name('post-search');
Route::post('/', [PostController::class, 'create'])->name('create-post');
Route::get('/post/{postid}', [PostController::class, 'postDetails'])->name('post-details');
Route::get('/edit-post/{postid}', [PostController::class, 'edit'])->name('edit-post');
Route::post('/update-post/{postid}', [PostController::class, 'update'])->name('update-post');

Route::post('/comment/{userid}/{postid}', [CommentController::class, 'create'])->name('add-comment');
Route::get('/edit-comment/{commentid}', [CommentController::class, 'edit'])->name('edit-comment');
Route::post('/update-comment/{commentid}', [CommentController::class, 'update'])->name('update-comment');



Route::post('/like/{postid}/{userid}', [LikeController::class, 'change'])->name('like');



Route::post('/edit-user/{userid}', [UserController::class, 'editUser'])->name('edit-user');


Route::post('/edit-user-photo/{userid}', [UserController::class, 'editUserPhoto'])->name('edit-user-photo');

Route::post('/change-password/{userid}', [UserController::class, 'changePassword'])->name('change-password');




Route::post('/add-friend/{friendId}', [UserController::class, 'addFriend'])->name('add-friend');

// routes/web.php

Route::get('/friend-requests', [FriendRequestController::class, 'index'])->name('friend-requests');
Route::post('/accept-friend-request/{requestId}', [FriendRequestController::class, 'accept'])->name('accept-friend-request');
Route::post('/decline-friend-request/{requestId}', [FriendRequestController::class, 'decline'])->name('decline-friend-request');


