<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;


// Route::get('/email/verify', function () {
//     return view('auth.verify-email');
// })->middleware(['auth'])->name('verification.notice');


Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])
  ->group(function () {
    // Route::get('/dashboard', fn() => view('dashboard'))
    //     ->name('dashboard');
  });

Route::get('/', HomeController::class)->name('home');


Route::prefix('/blog')->controller(PostController::class)->group(function () {
  Route::get('/', 'index')->name('posts.index');
  Route::get('/{post:slug}', 'show')->name('post.show');
});
