<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('project', [ProjectController::class, 'index'])->name('project');
Route::post('project', [ProjectController::class, 'store'])->name('project.store');
Route::patch('project/{id}', [ProjectController::class, 'update'])->name('project.update');

Route::get('category', [CategoryController::class, 'index'])->name('category');
Route::post('category', [CategoryController::class, 'store'])->name('category.store');

Route::get('activity', [ActivityController::class, 'index'])->name('activity');
Route::get('company', [CompanyController::class, 'index'])->name('company');

// Auth
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'doRegister'])->name('register.store');
Route::post('login', [AuthController::class, 'doLogin'])->name('login.process');
// Route::get('logout', [AuthController::class, 'logout'])->name('logout');
