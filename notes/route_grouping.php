<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider within a group
| that contains the "web" middleware group. Now create something great!
*/

/*
|--------------------------------------------------------------------------
| 1. Route Group with Prefix - Students
|--------------------------------------------------------------------------
| This group is for all routes related to students.
| The prefix "students" will be added to all routes within this group.
*/

Route::prefix('students')->group(function () {
    Route::get('/show', [StudentController::class, 'show'])->name('students.show');
    Route::get('/add', [StudentController::class, 'add'])->name('students.add');
    Route::get('/edit/{id}', [StudentController::class, 'edit'])->name('students.edit'); // with a dynamic parameter
    Route::get('/delete/{id}', [StudentController::class, 'delete'])->name('students.delete');
});

// More Nested Groups Routes

Route::prefix('admin')->group(function () {  
    // Routes for admin
    Route::prefix('students')->group(function () {
        Route::get('/show', [StudentController::class, 'show'])->name('admin.students.show');
        Route::get('/add', [StudentController::class, 'add'])->name('admin.students.add');
        Route::get('/edit', [StudentController::class, 'edit'])->name('admin.students.edit');
        Route::get('/delete', [StudentController::class, 'delete'])->name('admin.students.delete');
    });

    Route::prefix('teachers')->group(function () {
        Route::get('/show', [TeacherController::class, 'show'])->name('admin.teachers.show');
        Route::get('/add', [TeacherController::class, 'add'])->name('admin.teachers.add');
        Route::get('/edit', [TeacherController::class, 'edit'])->name('admin.teachers.edit');
        Route::get('/delete', [TeacherController::class, 'delete'])->name('admin.teachers.delete');
    });
});


/*
|--------------------------------------------------------------------------
| 2. Route Group with Middleware - Admin
|--------------------------------------------------------------------------
| This group is for all routes related to admin. Middleware "auth" ensures
| that only authenticated users can access these routes.
*/

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
});

/*
|--------------------------------------------------------------------------
| 3. Route Group with Prefix and Middleware - Secure Admin
|--------------------------------------------------------------------------
| This group adds extra security to admin routes by requiring both
| authentication and an admin role middleware.
*/

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::get('/logs', [AdminController::class, 'logs'])->name('admin.logs');
});


// Group routes with a controller for HomeController
Route::controller(HomeController::class)->group(function () {
    Route::get('/home', 'index')->name('home.index');
    Route::get('/about', 'about')->name('home.about');
    Route::get('/contact', 'contact')->name('home.contact');
    Route::get('/dashboard/{path?}', 'dashboard')->name('home.dashboard');
});


// Group routes with a prefix 'students' and controller for StudentController
Route::prefix('students')->controller(StudentController::class)->group(function () {
    Route::get('/show', 'show')->name('students.show');
    Route::get('/add', 'add')->name('students.add');
    Route::get('/edit', 'edit')->name('students.edit');
    Route::get('/delete', 'delete')->name('students.delete');
});


