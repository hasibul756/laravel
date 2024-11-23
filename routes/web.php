<?php

use Illuminate\Support\Facades\Route;
// Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BladeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\QueryController;
use App\Http\Controllers\ApiCallController;

// Middleware
use App\Http\Middleware\AgeCheck;
use App\Http\Middleware\CountryCheck;
use App\Http\Middleware\ImportDirectly;

// Basic GET route
Route::get('/', function () {
    return view('pages.home');
});

Route::view('/test', 'test');

Route::get('/blade', [BladeController::class, 'index']);

Route::get('/user_form', [UserController::class, 'index']);

Route::post('/add_user', [UserController::class, 'addUser']);

// Route::prefix('students')->group(function () {
//     Route::get('/show', [StudentController::class, 'show']);
//     Route::get('/add', [StudentController::class, 'add']);
//     Route::get('/edit', [StudentController::class, 'edit']);
//     Route::get('/delete', [StudentController::class, 'delete']);
// });

// Route::controller(HomeController::class)->group(function () {
//     Route::get('/home', 'index');
//     Route::get('/about', 'about');
//     Route::get('/contact', 'contact');
//     Route::get('/dashboard/{path?}', 'dashboard');
// });

// Route::prefix('students')->controller(StudentController::class)->group(function () {
//     Route::get('/show', 'show')->name('students.show');
//     Route::get('/add', 'add')->name('students.add');
//     Route::get('/edit/{id}', 'edit')->name('students.add');
// });

// Route::get('/student', [StudentController::class, 'show'])->middleware('check1');

// Route::middleware('check1')->controller(StudentController::class)->group(function () {
//     Route::get('/student', 'show');
//     Route::get('/student/add', 'add');
// });

// Route::get('/student/edit/{id}', [StudentController::class, 'edit'])->middleware(ImportDirectly::class);

// Route::get('/query',[QueryController::class, 'index']);

Route::prefix('students')->controller(StudentController::class)->group(function(){
    Route::get('', 'index')->name('students.show');
    Route::get('add', 'add')->name('students.add');
    Route::get('edit/{id}', 'edit')->name('students.edit');
    Route::get('delete/{id}', 'delete')->name('students.delete');
});

Route::get('/api-call', [ApiCallController::class, 'index']);