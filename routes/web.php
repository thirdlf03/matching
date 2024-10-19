<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomMemberController;
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
    Route::get('/roommember/create', [RoomMemberController::class, 'create'])->name('roommember.create');
    Route::post('/roommember', [RoomMemberController::class, 'store'])->name('roommember.store');
    Route::get('/roommember', [RoomMemberController::class, 'index'])->name('roommember.index');
    oute::delete('/roommember/{id}', [RoomMemberController::class, 'destroy'])->name('roommember.destroy');
});

require __DIR__.'/auth.php';
