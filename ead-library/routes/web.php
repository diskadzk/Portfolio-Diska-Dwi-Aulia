<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	return Auth::check()
		? redirect()->route('books.index')
		: redirect()->route('login');
});

Route::middleware('guest')->group(function (): void {
	Route::get('/login', [AuthController::class, 'createLogin'])->name('login');
	Route::post('/login', [AuthController::class, 'login'])->name('login.store');
	Route::get('/register', [AuthController::class, 'createRegister'])->name('register');
	Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function (): void {
	Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
	Route::resource('books', BookController::class);
});
