<?php

use App\Http\Controllers\PenyampaianController;

// Data
Route::get('/', [PenyampaianController::class, 'index'])->name('penyampaian')->middleware('rbac:penyampaian_tujuan');
Route::get('/data', [PenyampaianController::class, 'data'])->name('penyampaian.data')->middleware('rbac:penyampaian_tujuan');

// Excel
Route::get('/downloadExcel', [PenyampaianController::class, 'downloadExcel'])->name('penyampaian.downloadExcel')->middleware('rbac:penyampaian_tujuan');
