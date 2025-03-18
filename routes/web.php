<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('project', [ProjectController::class, 'index'])->name('project');
Route::post('project', [ProjectController::class, 'store'])->name('project.store');
Route::patch('project/{id}', [ProjectController::class, 'update'])->name('project.update');

Route::get('categoryAdmin', [CategoryController::class, 'admin'])->name('categoryAdmin');
Route::get('categoryActivity', [CategoryController::class, 'activity'])->name('categoryActivity');
// Route::post('category', [CategoryController::class, 'store'])->name('category.store');

Route::get('home', [HomeController::class, 'index'])->name('home');

Route::get('activity', [ActivityController::class, 'index'])->name('activity');
Route::get('company', [CompanyController::class, 'index'])->name('company');

// Auth
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'doLogin'])->name('login.process');
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'doRegister'])->name('register.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('get-token', [AuthController::class, 'getAccessToken'])->name('get-token');
