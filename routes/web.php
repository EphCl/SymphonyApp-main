<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserNotificationController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');
    Route::post('/posts/{post}/like', [LikeController::class, 'likePost'])->name('posts.like');
    Route::post('/posts/{post}/unlike', [LikeController::class, 'unlikePost'])->name('posts.unlike');

    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/comments/reply', [CommentController::class, 'reply'])->name('comments.reply');
    Route::post('/comments/{comment}/like', [LikeController::class, 'likeComment'])->name('comments.like');
    Route::post('/comments/{comment}/unlike', [LikeController::class, 'unlikeComment'])->name('comments.unlike');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profileUser.show');

    //Route::post('/follower', [UserController::class, 'following'])->name('user.follow');
    Route::post('/user/follow', [FollowerController::class, 'follow'])->name('user.follow');
    Route::delete('/user/unfollow', [FollowerController::class, 'unfollow'])->name('user.unfollow');
    // Route pour vérifier si un utilisateur suit un autre utilisateur
    Route::get('/user/is-following/{id}', [FollowerController::class, 'isFollowing'])->name('user.isFollowing');

    Route::get('/search', [SearchController::class, 'index'])->name('search.index');

    Route::get('/notifications', [UserNotificationController::class, 'index'])->name('notifications.index');

    Route::get('/song', [SongController::class, 'store'])->name('song.store');
});
