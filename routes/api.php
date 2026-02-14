<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FriendsController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);

    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);

    Route::get('/friends', [FriendsController::class, 'friendsList']);
    Route::get('/friends/{userId}', [FriendsController::class, 'viewOthers']);
    Route::post('/friends/send-request/{id}', [FriendsController::class, 'sendRequest']);
    Route::post('/friends/accept-request/{id}', [FriendsController::class, 'acceptRequest']);
    Route::delete('/friends/reject-request/{id}', [FriendsController::class, 'rejectRequest']);

    Route::apiResource('posts', PostController::class);

    Route::get('/all-posts', [PostController::class, 'getAllPosts']);
    Route::post('/posts/{id}/comments', [PostController::class, 'addComment']);
    Route::post('/posts/{id}/like', [PostController::class, 'like']);
    Route::get('/posts/{id}/likes', [PostController::class, 'showLikes']);

});

