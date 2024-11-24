<?php

use App\Http\Controllers\PeminjamanController;

Route::get('/', [PeminjamanController::class, 'index'])->name('peminjaman')->middleware('rbac:peminjaman');
Route::get('/data', [PeminjamanController::class, 'data'])->name('peminjaman.data')->middleware('rbac:peminjaman');
Route::post('/store', [PeminjamanController::class, 'store'])->name('peminjaman.store')->middleware('rbac:peminjaman,2');
Route::patch('/update', [PeminjamanController::class, 'update'])->name('peminjaman.update')->middleware('rbac:peminjaman,3');
Route::delete('/delete', [PeminjamanController::class, 'delete'])->name('peminjaman.delete')->middleware('rbac:peminjaman,4');
