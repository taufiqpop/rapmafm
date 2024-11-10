<?php

use App\Http\Controllers\UsersController;

Route::get('/', [UsersController::class, 'index'])->name('users')->middleware('rbac:pengguna');
Route::get('/data', [UsersController::class, 'data'])->name('users.data')->middleware('rbac:pengguna');
Route::post('/store', [UsersController::class, 'store'])->name('users.store')->middleware('rbac:pengguna,2');
Route::patch('/update', [UsersController::class, 'update'])->name('users.update')->middleware('rbac:pengguna,3');
Route::patch('/switch', [UsersController::class, 'switchStatus'])->name('users.switch')->middleware('rbac:pengguna,3');
Route::delete('/delete', [UsersController::class, 'delete'])->name('users.delete')->middleware('rbac:pengguna,4');
Route::patch('/update/roles', [UsersController::class, 'updateRole'])->name('users.update.roles')->middleware('rbac:pengguna,3');
Route::patch('/reset-password', [UsersController::class, 'resetPassword'])->name('users.reset-password')->middleware('rbac:pengguna,3');
Route::patch('/change-password', [UsersController::class, 'changePassword'])->name('users.change-password');
Route::patch('/change-profile', [UsersController::class, 'changeProfile'])->name('users.change-profile');
Route::get('/get-profile', [UsersController::class, 'getProfile'])->name('users.get-profile');
