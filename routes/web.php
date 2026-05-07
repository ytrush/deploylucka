<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectionController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user instanceof User && $user->hasAnyRole(['admin', 'super_admin', '2', '3'])) {
        return redirect('/admin');
    }

    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Read-only pages for all authenticated users (user/admin/super_admin).
    Route::resource('categories', CategoryController::class)->only(['index', 'show']);
    Route::resource('courses', CourseController::class)->only(['index', 'show']);
    Route::resource('sections', SectionController::class)->only(['index', 'show']);
    Route::resource('materis', MateriController::class)->only(['index', 'show']);

    // Management pages/actions restricted to admin and super_admin.
    Route::middleware('role:admin,super_admin')->group(function () {
        Route::resource('categories', CategoryController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
        Route::resource('courses', CourseController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
        Route::resource('sections', SectionController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
        Route::resource('materis', MateriController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
    });
});

// Route::get('/home', function () {
//     return view('home');
// });

require __DIR__.'/auth.php';
