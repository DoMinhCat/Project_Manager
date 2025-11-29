<?php

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

// 1. MAIN PAGES
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/projects', function () {
    return view('projects');
})->name('projects');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// LOGIN/SIGN UP
Route::post('/login', [UserController::class, 'store']);
