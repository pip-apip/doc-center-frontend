<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

use App\Http\Middleware\AuthMiddleware;


Route::get('/', function () {
    return redirect()->route('login');
});

// Auth
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'doLogin'])->name('login.process');
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'doRegister'])->name('register.store');
Route::get('get-token', [AuthController::class, 'getAccessToken'])->name('get-token');

Route::post('/logout', function () {
    session()->flush();
    return redirect('/login');
})->name('logout');


// Route::get('user', [AuthController::class, 'user'])->name('user');
Route::middleware([AuthMiddleware::class])->group(function () {
    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::get('project', [ProjectController::class, 'index'])->name('project');
    Route::get('company', [CompanyController::class, 'index'])->name('company');
    Route::get('categoryAdmin', [CategoryController::class, 'admin'])->name('categoryAdmin');
    Route::get('categoryActivity', [CategoryController::class, 'activity'])->name('categoryActivity');
    Route::get('activity', [ActivityController::class, 'index'])->name('activity');
    Route::get('/activity-project/{id}', [ActivityController::class, 'activity_project'])->name('activity.project');
});

// Route::post('project', [ProjectController::class, 'store'])->name('project.store');
// Route::patch('project/{id}', [ProjectController::class, 'update'])->name('project.update');

// Route::post('category', [CategoryController::class, 'store'])->name('category.store');




