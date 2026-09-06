<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\StatusUpdateController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);
    Route::post('users/{user}/assign-roles', [RoleController::class, 'assignRole'])
        ->name('users.assignRole');

    Route::resource('roles', RoleController::class);
});

Route::middleware(['auth', 'role:admin,manager'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('projects', ProjectController::class);
    Route::resource('tasks', TaskController::class);
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::post('tasks/{task}/updates', [StatusUpdateController::class, 'store'])
        ->name('status-updates.store');
    Route::delete('tasks/{task}/updates/{update}', [StatusUpdateController::class, 'destroy'])
        ->name('status-updates.destroy');
});

require __DIR__.'/auth.php';