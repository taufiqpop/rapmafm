<?php

use App\Http\Controllers\ImplementasiController;

// Load Halaman
Route::get('/', [ImplementasiController::class, 'index'])->name('implementasi')->middleware('rbac:implementasi_teknik_penilaian');
Route::post('/load_halaman', [ImplementasiController::class, 'load_halaman'])->name('implementasi.load_halaman')->middleware('rbac:implementasi_teknik_penilaian,2');
Route::get('/data', [ImplementasiController::class, 'data'])->name('implementasi.data')->middleware('rbac:implementasi_teknik_penilaian');

// Soal & Kunci Jawaban
Route::patch('/uploadSoal', [ImplementasiController::class, 'uploadSoal'])->name('implementasi.uploadSoal')->middleware('rbac:implementasi_teknik_penilaian,3');
Route::delete('/deleteSoal/{id}', [ImplementasiController::class, 'deleteSoal'])->name('implementasi.deleteSoal')->middleware('rbac:implementasi_teknik_penilaian,4');

// Dokumentasi
Route::get('/dataDokumentasi', [ImplementasiController::class, 'dataDokumentasi'])->name('implementasi.dataDokumentasi')->middleware('rbac:implementasi_teknik_penilaian');
Route::post('/uploadDokumentasi', [ImplementasiController::class, 'uploadDokumentasi'])->name('implementasi.uploadDokumentasi')->middleware('rbac:implementasi_teknik_penilaian');
Route::delete('/deleteDokumentasi', [ImplementasiController::class, 'deleteDokumentasi'])->name('implementasi.deleteDokumentasi')->middleware('rbac:implementasi_teknik_penilaian');

// Excel
Route::get('/downloadExcel', [ImplementasiController::class, 'downloadExcel'])->name('implementasi.downloadExcel')->middleware('rbac:implementasi_teknik_penilaian');
Route::patch('/importExcel', [ImplementasiController::class, 'importExcel'])->name('implementasi.importExcel')->middleware('rbac:implementasi_teknik_penilaian,3');
Route::delete('/deleteExcel/{id}', [ImplementasiController::class, 'deleteExcel'])->name('implementasi.deleteExcel')->middleware('rbac:implementasi_teknik_penilaian,4');
Route::get('/fetchExcelContent', [ImplementasiController::class, 'fetchExcelContent'])->name('implementasi.fetchExcelContent')->middleware('rbac:implementasi_teknik_penilaian');
Route::get('/previewPenilaian', [ImplementasiController::class, 'previewPenilaian'])->name('implementasi.previewPenilaian')->middleware('rbac:implementasi_teknik_penilaian');

// Penilaian
Route::get('/downloadPenilaian/{id}', [ImplementasiController::class, 'downloadPenilaian'])->name('implementasi.downloadPenilaian')->middleware('rbac:implementasi_teknik_penilaian');
