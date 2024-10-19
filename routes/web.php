<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomMemberController;
use App\Http\Controllers\ChatController;

use Illuminate\Support\Facades\Route;

if (env('APP_ENV') == 'production') {
    \Illuminate\Support\Facades\URL::forceScheme('https');
}

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect()->route('rooms.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('rooms', RoomController::class);
    Route::resource('roomMembers', RoomMemberController::class);
    Route::get('/rooms',[ChatController::class,'index'])->name('chat.index');
    Route::post('/rooms',[ChatController::class,'store'])->name('chat.store');
    Route::get('/rooms/create',[ChatController::class,'create'])->name('chat.create');
    Route::delete('/rooms/{room}',[ChatController::class,'destroy'])->name('chat.destroy');
    //Route::resource('chats',ChatController::class);
});

require __DIR__.'/auth.php';
