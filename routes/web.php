<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryAdmController;
use App\Http\Controllers\CategoryActController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\RefershTokenMiddleware;


Route::get('/', function () {
    return redirect()->route('login');
});

// Auth
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'doLogin'])->name('login.process');
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::get('get-token', [AuthController::class, 'refreshAccessToken'])->name('get-token');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware([AuthMiddleware::class, RefershTokenMiddleware::class])->group(function () {
    Route::get('home', [HomeController::class, 'index'])->name('home');

    // Category Administration
    Route::get('categoryAdm', [CategoryAdmController::class, 'index'])->name('categoryAdm.index');
    Route::get('categoryAdm/form', [CategoryAdmController::class, 'create'])->name('categoryAdm.create');
    Route::post('categoryAdm/store', [CategoryAdmController::class, 'store'])->name('categoryAdm.store');
    Route::get('categoryAdm/form-edit/{id}', [CategoryAdmController::class, 'edit'])->name('categoryAdm.edit');
    Route::post('categoryAdm/update/{id}', [CategoryAdmController::class, 'update'])->name('categoryAdm.update');
    Route::get('categoryAdm/delete/{id}', [CategoryAdmController::class, 'destroy'])->name('categoryAdm.destroy');

    // Category Activity
    Route::get('categoryAct', [CategoryActController::class, 'index'])->name('categoryAct.index');
    Route::get('categoryAct/form', [CategoryActController::class, 'create'])->name('categoryAct.create');
    Route::post('categoryAct/store', [CategoryActController::class, 'store'])->name('categoryAct.store');
    Route::get('categoryAct/form-edit/{id}', [CategoryActController::class, 'edit'])->name('categoryAct.edit');
    Route::post('categoryAct/update/{id}', [CategoryActController::class, 'update'])->name('categoryAct.update');
    Route::get('categoryAct/delete/{id}', [CategoryActController::class, 'destroy'])->name('categoryAct.destroy');

    // Company
    Route::get('company', [CompanyController::class, 'index'])->name('company.index');
    Route::get('company/form', [CompanyController::class, 'create'])->name('company.create');
    Route::post('company/store', [CompanyController::class, 'store'])->name('company.store');
    Route::get('company/form-edit/{id}', [CompanyController::class, 'edit'])->name('company.edit');
    Route::post('company/update/{id}', [CompanyController::class, 'update'])->name('company.update');
    Route::get('company/delete/{id}', [CompanyController::class, 'destroy'])->name('company.destroy');

    // Project
    Route::get('project', [ProjectController::class, 'index'])->name('project.index');
    Route::get('project/doc/{id}', [ProjectController::class, 'show'])->name('project.doc');
    Route::get('project/form', [ProjectController::class, 'create'])->name('project.create');
    Route::post('project/store', [ProjectController::class, 'store'])->name('project.store');
    Route::post('project/storeDoc', [ProjectController::class, 'storeDoc'])->name('project.store.doc');
    Route::get('project/form-edit/{id}', [ProjectController::class, 'edit'])->name('project.edit');
    Route::post('project/update/{id}', [ProjectController::class, 'update'])->name('project.update');
    Route::get('project/destroy/{id}', [ProjectController::class, 'destroy'])->name('project.destroy');
    Route::get('project/destroyDoc/{id}', [ProjectController::class, 'destroyDoc'])->name('project.destroy.doc');

    // Activity
    Route::get('activity', [ActivityController::class, 'index'])->name('activity.index');
    Route::get('activity/doc/{id}', [ActivityController::class, 'show'])->name('activity.doc');
    Route::get('activity/activity-project/{id}', [ActivityController::class, 'activity_project'])->name('activity.project');
    Route::post('activity/doc/store', [ActivityController::class, 'storeDoc'])->name('activity.doc.store');
    Route::get('activity/doc/delete/{id}', [ActivityController::class, 'destroyDoc'])->name('activity.doc.delete');
    Route::get('activity/form', [ActivityController::class, 'create'])->name('activity.create');
    Route::post('activity/form', [ActivityController::class, 'store'])->name('activity.store');
    Route::get('activity/form-edit/{id}', [ActivityController::class, 'edit'])->name('activity.edit');
    Route::post('activity/update/{id}', [ActivityController::class, 'update'])->name('activity.update');
    Route::get('activity/destroy/{id}', [ActivityController::class, 'destroy'])->name('activity.destroy');

    Route::get('user', [UserController::class, 'index'])->name('user.index');
    Route::get('user/form', [UserController::class, 'create'])->name('user.create');
    Route::post('user', [AuthController::class, 'doRegister'])->name('user.store');
    Route::get('user/form-edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('user/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::get('user/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');


    Route::get('/activity-project/{id}', [ActivityController::class, 'activity_project'])->name('activity.project');
});

Route::get('test', function () {
    $title = 'Test';
    return view('pages.test', compact('title'));
})->name('test');


// Route::post('project', [ProjectController::class, 'store'])->name('project.store');
// Route::patch('project/{id}', [ProjectController::class, 'update'])->name('project.update');

// Route::post('category', [CategoryController::class, 'store'])->name('category.store');




