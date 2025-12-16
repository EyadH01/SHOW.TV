<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\EpisodeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', function () {
    return redirect()->route('home');
})->name('dashboard');
Route::get('/search', [HomeController::class, 'search'])->name('search');

Route::get('/shows', [ShowController::class, 'index'])->name('shows.index');
Route::get('/shows/{show}', [ShowController::class, 'show'])->name('shows.show');

Route::middleware('auth')->group(function () {
    Route::post('/shows/{show}/follow', [ShowController::class, 'follow'])->name('shows.follow');
    Route::delete('/shows/{show}/follow', [ShowController::class, 'unfollow'])->name('shows.unfollow');

    Route::post('/episodes/{episode}/like', [EpisodeController::class, 'like'])->name('episodes.like');
    Route::post('/episodes/{episode}/dislike', [EpisodeController::class, 'dislike'])->name('episodes.dislike');
    Route::delete('/episodes/{episode}/like', [EpisodeController::class, 'unlike'])->name('episodes.unlike');
    
    // Profile routes
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

Route::get('/episodes/{episode}', [EpisodeController::class, 'show'])->name('episodes.show');

Auth::routes();

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');

    // Shows Management
    Route::resource('shows', \App\Http\Controllers\Admin\ShowController::class);

    // Episodes Management
    Route::resource('episodes', \App\Http\Controllers\Admin\EpisodeController::class);

    // User Management
    Route::get('/users', [\App\Http\Controllers\Admin\AdminController::class, 'users'])->name('users.index');
});
