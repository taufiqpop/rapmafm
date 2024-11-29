<?php

use App\Http\Controllers\Kepenyiaran\JadwalSiarController;

Route::get('/', [JadwalSiarController::class, 'index'])->name('jadwal-siar')->middleware('rbac:jadwal_siar');
Route::get('/edit', [JadwalSiarController::class, 'edit'])->name('jadwal-siar.edit')->middleware('rbac:jadwal_siar');
Route::post('/update_custom', [JadwalSiarController::class, 'update_custom'])->name('jadwal-siar.update_custom')->middleware('rbac:jadwal_siar');
