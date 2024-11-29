<?php

use App\Http\Controllers\Umum\JadwalPiketController;

Route::get('/', [JadwalPiketController::class, 'index'])->name('jadwal-piket')->middleware('rbac:jadwal_piket');
Route::get('/edit', [JadwalPiketController::class, 'edit'])->name('jadwal-piket.edit')->middleware('rbac:jadwal_piket');
Route::post('/update_custom', [JadwalPiketController::class, 'update_custom'])->name('jadwal-piket.update_custom')->middleware('rbac:jadwal_piket');
