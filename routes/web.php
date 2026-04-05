<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Read-only pages for all authenticated users (user/admin/super_admin).
    Route::resource('courses', CourseController::class)->only(['index', 'show']);
    Route::resource('sections', SectionController::class)->only(['index', 'show']);
    Route::resource('lessons', LessonController::class)->only(['index', 'show']);

    // Management pages/actions restricted to admin and super_admin.
    Route::middleware('role:admin,super_admin')->group(function () {
        Route::resource('courses', CourseController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
        Route::resource('sections', SectionController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
        Route::resource('lessons', LessonController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
    });
});

// Route::get('/home', function () {
//     return view('home');
// });

require __DIR__.'/auth.php';
