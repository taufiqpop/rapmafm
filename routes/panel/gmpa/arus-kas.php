<?php

use App\Http\Controllers\GMPA\ArusKasController;

Route::get('/', [ArusKasController::class, 'index'])->name('arus-kas')->middleware('rbac:arus_kas');
Route::get('/data', [ArusKasController::class, 'data'])->name('arus-kas.data')->middleware('rbac:arus_kas');
Route::post('/store', [ArusKasController::class, 'store'])->name('arus-kas.store')->middleware('rbac:arus_kas,2');
Route::patch('/update', [ArusKasController::class, 'update'])->name('arus-kas.update')->middleware('rbac:arus_kas,3');
Route::delete('/delete', [ArusKasController::class, 'delete'])->name('arus-kas.delete')->middleware('rbac:arus_kas,4');
