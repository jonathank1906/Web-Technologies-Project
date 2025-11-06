<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Livewire\Home;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->middleware('auth')->name('home');

Route::get('/messages', \App\Livewire\Messages\Index::class)->middleware('auth')->name('messages');
Route::get('/swipe', \App\Livewire\Swipe\Item::class)->middleware('auth')->name('swipe');
Route::get('/connections', \App\Livewire\Connections\Index::class)->middleware('auth')->name('connections');
Route::get('/post/create', \App\Livewire\Post\Create::class)->middleware('auth')->name('post.create');
Route::post('/posts/{post}/toggle-like', [PostController::class, 'toggleLike'])->middleware('auth');
Route::get('/posts/{post}', \App\Livewire\Post\Show::class)->middleware('auth')->name('post.show');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('post.destroy');

Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        return redirect()->route('profile.show', ['user' => auth()->user()]);
    })->name('profile.my');
    
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/{user}/follow', [ProfileController::class, 'follow'])->name('profile.follow');
    Route::delete('/profile/{user}/unfollow', [ProfileController::class, 'unfollow'])->name('profile.unfollow');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
