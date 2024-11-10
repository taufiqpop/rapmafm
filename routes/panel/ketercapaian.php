<?php

use App\Http\Controllers\KetercapaianController;

// Data
Route::get('/', [KetercapaianController::class, 'index'])->name('ketercapaian')->middleware('rbac:ketercapaian_tujuan');
Route::get('/data', [KetercapaianController::class, 'data'])->name('ketercapaian.data')->middleware('rbac:ketercapaian_tujuan');
Route::get('/edit/{encrypted_id}', [KetercapaianController::class, 'edit'])->name('ketercapaian.edit')->middleware('rbac:ketercapaian_tujuan');

// Autosave
Route::post('/ketercapaian/update_custom', [KetercapaianController::class, 'update_custom'])->name('ketercapaian.update_custom')->middleware('rbac:ketercapaian_tujuan');

// Download PDF
Route::get('/downloadKetercapaian/{encrypted_id}', [KetercapaianController::class, 'downloadKetercapaian'])->name('ketercapaian.downloadKetercapaian')->middleware('rbac:ketercapaian_tujuan');
