<?php

use App\Http\Controllers\AlumniController;

Route::get('/', [AlumniController::class, 'index'])->name('alumni')->middleware('rbac:alumni');
Route::get('/data', [AlumniController::class, 'data'])->name('alumni.data')->middleware('rbac:alumni');
Route::post('/store', [AlumniController::class, 'store'])->name('alumni.store')->middleware('rbac:alumni,2');
Route::patch('/update', [AlumniController::class, 'update'])->name('alumni.update')->middleware('rbac:alumni,3');
Route::delete('/delete', [AlumniController::class, 'delete'])->name('alumni.delete')->middleware('rbac:alumni,4');
