<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomMemberController;
use App\Http\Controllers\RoomRoleController;
use Illuminate\Support\Facades\Route;
use App\Events\MyEvent;

if (env('APP_ENV') == 'production') {
    \Illuminate\Support\Facades\URL::forceScheme('https');
}

Route::get('auth/google', [LoginController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [LoginController::class, 'handleGoogleCallback']);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect()->route('rooms.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::post('/follow/{user}', [FollowController::class, 'store'])->name('follow.store');
    Route::delete('/follow/{user}', [FollowController::class, 'destroy'])->name('follow.destroy');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/{user}/followers', [ProfileController::class, 'showFollowers'])->name('profile.followers');
    Route::get('/profile/{user}/following', [ProfileController::class, 'showFollowing'])->name('profile.following');
    Route::get('/rooms/search', [RoomController::class, 'search'])->name('rooms.search');
    Route::resource('rooms', RoomController::class);
    Route::resource('roomMembers', RoomMemberController::class);
    Route::post('/chats', [ChatController::class, 'store'])->name('chat.store');
    Route::delete('/chats/{chat}', [ChatController::class, 'destroy'])->name('chat.destroy');
    //Route::resource('chats',ChatController::class);
    Route::post('/room_roles', [RoomRoleController::class, 'store'])->name('room_role.store');
    Route::delete('/room_roles/{room_role}', [RoomRoleController::class, 'destroy'])->name('room_role.destroy');

});

require __DIR__.'/auth.php';
