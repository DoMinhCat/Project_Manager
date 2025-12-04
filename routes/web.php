<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

// 1. MAIN PAGES
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');


// DASHBOARD

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

/*
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
*/


// USER
Route::get('/register', function () {
    return view('user.register');
})->name('register');
Route::post('/resgister/submit', [UserController::class, 'store'])->name('register.submit');
Route::get('/login', function () {
    return view('user.login');
})->name('login');
Route::post('/login/submit', [UserController::class, 'login'])->name('login.submit');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');
Route::get('/user/{user}', [UserController::class, 'show'])->name('account');

// PROJECT
Route::get('/projects', [ProjectController::class, 'index'])->name('project.all');
Route::post('/projects/create', [ProjectController::class, 'store'])->name('project.create');
Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('project.detail');
Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('project.delete');
Route::patch('/projects/{project}', [ProjectController::class, 'update'])->name('project.update');

// TASK
Route::post('/projects/{project}/tasks/create', [TaskController::class, 'store'])->name('task.create');
Route::get('/projects/{project}/tasks/{task}', [TaskController::class, 'show'])->name('task.detail');
Route::delete('/projects/{project}/tasks/{task}', [TaskController::class, 'destroy'])->name('task.delete');
Route::patch('/projects/{project}/tasks/{task}', [TaskController::class, 'update'])->name('task.update');

