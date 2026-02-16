<?php

use App\Http\Controllers\FriendsController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');


    Route::get('/friends/search', [FriendsController::class, 'search'])->name('friends.search');

    Route::get('/posts/create', [PostsController::class, 'create'])->name('posts.create');//
    Route::post('/posts', [PostsController::class, 'storePost'])->name('posts.store');//
    Route::get('/posts/{id}', [PostsController::class, 'showPost'])->name('posts.show');
    Route::get('/posts/{id}/edit', [PostsController::class, 'editPost'])->name('posts.edit');
    Route::put('/posts/{id}', [PostsController::class, 'updatePost'])->name('posts.update');
    Route::delete('/posts/{id}', [PostsController::class, 'deletePost'])->name('posts.delete');
    Route::post('/posts/{id}/like', [PostsController::class, 'like'])->name('posts.like');
    Route::get('/posts/{id}/likes', [PostsController::class, 'showLikes'])->name('posts.likes');
    Route::post('/posts/{id}/comment', [PostsController::class, 'comment'])->name('posts.comment');
    Route::get('all-posts', [PostsController::class, 'getAllPosts'])->name('posts.all');


    Route::get('/friends', [FriendsController::class, 'index'])->name('friends.index');
    Route::get('/friends/user/{id}', [FriendsController::class, 'viewUser'])->name('friends.user');
    Route::post('/friends/send/{id}', [FriendsController::class, 'sendRequest'])->name('friends.send');
    Route::post('/friends/accept/{id}', [FriendsController::class, 'accept'])->name('friends.accept');
    Route::delete('/friends/reject/{id}', [FriendsController::class, 'reject'])->name('friends.reject');
    Route::get('/friends/requests', [FriendsController::class, 'myRequests'])->name('friends.requests');


});

require __DIR__ . '/auth.php';
