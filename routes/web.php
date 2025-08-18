<?php

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\OwnerController;
use App\Http\Controllers\Admin\UserController;

Route::get('/', [UploadController::class, 'index'])->name('dashboard');
Route::post('/upload', [UploadController::class, 'upload'])->name('upload.file');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () { // Added middleware
    Route::resource('owners', OwnerController::class)->names('admin.owners');
    Route::get('owners/{owner}/download-config', [OwnerController::class, 'downloadConfig'])->name('admin.owners.downloadConfig');
    Route::get('owners/{owner}/download-keystore', [OwnerController::class, 'downloadKeystore'])->name('admin.owners.downloadKeystore');
    Route::resource('users', UserController::class)->names('admin.users');
    Route::get('users/{user}/roles/edit', [UserController::class, 'editRoles'])->name('admin.users.editRoles')->middleware('permission:manage users');
    Route::put('users/{user}/roles', [UserController::class, 'updateRoles'])->name('admin.users.updateRoles')->middleware('permission:manage users');
    Route::get('users/{user}/background-signature', [UserController::class, 'backgroundSignature'])->name('admin.users.backgroundSignature');

    // Role Management Routes
    Route::resource('roles', RoleController::class)->names('admin.roles')->middleware('permission:manage roles');
});

require __DIR__ . '/auth.php';