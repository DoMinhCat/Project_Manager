<?php

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

// 1. MAIN PAGES
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', function () {
    return view('user.login');
})->name('login');

Route::get('/register', function () {
    return view('user.register');
})->name('register');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/projects', function () {
    return view('project.projects');
})->name('projects');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// USER
Route::post('/login/submit', [UserController::class, 'login'])->name('login.submit');
Route::post('/resgister/submit', [UserController::class, 'store'])->name('register.submit');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');
Route::get('/user/{user_id}', [UserController::class, 'show'])->name('account');



