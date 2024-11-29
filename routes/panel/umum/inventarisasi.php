<?php

use App\Http\Controllers\Umum\InventarisasiController;

Route::get('/', [InventarisasiController::class, 'index'])->name('inventarisasi')->middleware('rbac:inventarisasi');
Route::get('/data', [InventarisasiController::class, 'data'])->name('inventarisasi.data')->middleware('rbac:inventarisasi');
Route::post('/store', [InventarisasiController::class, 'store'])->name('inventarisasi.store')->middleware('rbac:inventarisasi,2');
Route::patch('/update', [InventarisasiController::class, 'update'])->name('inventarisasi.update')->middleware('rbac:inventarisasi,3');
Route::delete('/delete', [InventarisasiController::class, 'delete'])->name('inventarisasi.delete')->middleware('rbac:inventarisasi,4');
