<?php

use App\Http\Controllers\Personalia\PengurusController;

Route::get('/', [PengurusController::class, 'index'])->name('pengurus')->middleware('rbac:pengurus');
Route::get('/data', [PengurusController::class, 'data'])->name('pengurus.data')->middleware('rbac:pengurus');
Route::post('/store', [PengurusController::class, 'store'])->name('pengurus.store')->middleware('rbac:pengurus,2');
Route::patch('/update', [PengurusController::class, 'update'])->name('pengurus.update')->middleware('rbac:pengurus,3');
Route::delete('/delete', [PengurusController::class, 'delete'])->name('pengurus.delete')->middleware('rbac:pengurus,4');
Route::patch('/switch', [PengurusController::class, 'switchStatus'])->name('pengurus.switch')->middleware('rbac:pengurus,3');
