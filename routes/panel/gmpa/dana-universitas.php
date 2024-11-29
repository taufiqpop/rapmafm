<?php

use App\Http\Controllers\GMPA\DanaUniversitasController;

Route::get('/', [DanaUniversitasController::class, 'index'])->name('dana-universitas')->middleware('rbac:dana_universitas');
Route::get('/data', [DanaUniversitasController::class, 'data'])->name('dana-universitas.data')->middleware('rbac:dana_universitas');
Route::post('/store', [DanaUniversitasController::class, 'store'])->name('dana-universitas.store')->middleware('rbac:dana_universitas,2');
Route::patch('/update', [DanaUniversitasController::class, 'update'])->name('dana-universitas.update')->middleware('rbac:dana_universitas,3');
Route::delete('/delete', [DanaUniversitasController::class, 'delete'])->name('dana-universitas.delete')->middleware('rbac:dana_universitas,4');
