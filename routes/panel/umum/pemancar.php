<?php

use App\Http\Controllers\Umum\PemancarController;

Route::get('/', [PemancarController::class, 'index'])->name('pemancar')->middleware('rbac:pemancar');
Route::get('/data', [PemancarController::class, 'data'])->name('pemancar.data')->middleware('rbac:pemancar');
Route::post('/store', [PemancarController::class, 'store'])->name('pemancar.store')->middleware('rbac:pemancar,2');
Route::patch('/update', [PemancarController::class, 'update'])->name('pemancar.update')->middleware('rbac:pemancar,3');
Route::delete('/delete', [PemancarController::class, 'delete'])->name('pemancar.delete')->middleware('rbac:pemancar,4');
