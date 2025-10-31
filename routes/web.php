<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Livewire\Home;
use Illuminate\Support\Facades\Route;


Route::get('/', Home::class)->middleware('auth')->name('home');

Route::get('/messages', \App\Livewire\Messages\Index::class)->middleware('auth')->name('messages');
Route::get('/swipe', \App\Livewire\Swipe\Item::class)->middleware('auth')->name('swipe');
Route::get('/connections', \App\Livewire\Connections\Index::class)->middleware('auth')->name('connections');
Route::get('/post/create', \App\Livewire\Post\Create::class)->middleware('auth')->name('post.create');
Route::post('/posts/{post}/toggle-like', [PostController::class, 'toggleLike'])->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';