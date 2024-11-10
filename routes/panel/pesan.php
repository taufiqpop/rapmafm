<?php

use App\Http\Controllers\PesanController;

Route::get('/', [PesanController::class, 'index'])->name('pesan')->middleware('rbac:pesan');
Route::get('/data', [PesanController::class, 'data'])->name('pesan.data')->middleware('rbac:pesan');
Route::post('/store', [PesanController::class, 'store'])->name('pesan.store')->middleware('rbac:pesan,2');
Route::patch('/update', [PesanController::class, 'update'])->name('pesan.update')->middleware('rbac:pesan,3');
Route::delete('/delete', [PesanController::class, 'delete'])->name('pesan.delete')->middleware('rbac:pesan,4');
