<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Livewire\Home;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/stream-attachment/{path}', function ($path) {
    $disk = Storage::disk('public');

    if (!$disk->exists($path)) {
        abort(404);
    }

    $fullPath = $disk->path($path);
    $fileSize = filesize($fullPath);
    $file = fopen($fullPath, 'rb');
    
    $start = 0;
    $end = $fileSize - 1;

    // Check if the browser is asking for a specific range (seeking)
    if (isset($_SERVER['HTTP_RANGE'])) {
        $c_start = $start;
        $c_end = $end;

        list(, $range) = explode('=', $_SERVER['HTTP_RANGE'], 2);
        if (strpos($range, ',') !== false) {
            header('HTTP/1.1 416 Requested Range Not Satisfiable');
            header("Content-Range: bytes $start-$end/$fileSize");
            exit;
        }
        if ($range == '-') {
            $c_start = $fileSize - substr($range, 1);
        } else {
            $range = explode('-', $range);
            $c_start = $range[0];
            $c_end = (isset($range[1]) && is_numeric($range[1])) ? $range[1] : $c_end;
        }
        $c_end = ($c_end > $end) ? $end : $c_end;
        
        if ($c_start > $c_end || $c_start > $fileSize - 1 || $c_end >= $fileSize) {
            header('HTTP/1.1 416 Requested Range Not Satisfiable');
            header("Content-Range: bytes $start-$end/$fileSize");
            exit;
        }
        
        $start = $c_start;
        $end = $c_end;
        $length = $end - $start + 1;
        
        fseek($file, $start);
        
        // This is the magic header that lets you seek
        header('HTTP/1.1 206 Partial Content'); 
        header("Content-Length: " . $length);
        header("Content-Range: bytes $start-$end/$fileSize");
    } else {
        // No seek request, just send the length
        header("Content-Length: " . $fileSize);
    }

    // Standard Headers
    header('Content-Type: ' . $disk->mimeType($path));
    header('Accept-Ranges: bytes');

    // Stream the data
    while (!feof($file) && ($p = ftell($file)) <= $end) {
        if ($p + 1024 * 8 > $end) {
            echo fread($file, $end - $p + 1);
        } else {
            echo fread($file, 1024 * 8);
        }
        flush(); // Force output to browser
    }

    fclose($file);
    exit;

})->where('path', '.*')->name('stream.attachment');
/*
--------------------------------------------------------------------------
 Public (Guest) Routes
--------------------------------------------------------------------------
 Guests can browse posts, see connections, and view public profiles.
*/
Route::get('/', Home::class)->name('home');
Route::get('/connections', \App\Livewire\Connections\Index::class)->name('connections');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');

/*
--------------------------------------------------------------------------
 Authenticated Routes
--------------------------------------------------------------------------
 Routes below are only accessible to logged-in users.
 Trying to access these while unauthenticated redirects to /login.
*/
Route::middleware('auth')->group(function () {
    Route::get('/messages', \App\Livewire\Messages\Index::class)->name('messages');
    Route::get('/swipe', \App\Livewire\Swipe\Item::class)->name('swipe');

    Route::get('/post/create', \App\Livewire\Post\Create::class)->name('post.create');
    Route::post('/posts/{post}/toggle-like', [PostController::class, 'toggleLike'])->name('post.like');
    Route::get('/posts/{post}', \App\Livewire\Post\Show::class)->name('post.show');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('post.destroy');

    Route::get('/profile', function () {
        return redirect()->route('profile.show', ['user' => auth()->user()]);
    })->name('profile.my');

    Route::post('/profile/{user}/follow', [ProfileController::class, 'follow'])->name('profile.follow');
    Route::delete('/profile/{user}/unfollow', [ProfileController::class, 'unfollow'])->name('profile.unfollow');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
