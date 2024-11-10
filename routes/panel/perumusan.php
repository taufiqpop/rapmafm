<?php

use App\Http\Controllers\PerumusanController;
use App\Http\Controllers\BlueprintController;
use App\Http\Controllers\RubrikController;
use App\Http\Controllers\SekolahController;

// Terminologi
Route::get('/', [PerumusanController::class, 'index'])->name('perumusan')->middleware('rbac:perumusan_tujuan');
Route::post('/updateStatus', [PerumusanController::class, 'updateStatus'])->name('perumusan.updateStatus')->middleware('rbac:perumusan_tujuan,2');

// Load Halaman
Route::post('/load_halaman', [PerumusanController::class, 'load_halaman'])->name('perumusan.load_halaman')->middleware('rbac:perumusan_tujuan,2');

// Sekolah
Route::get('/sekolah/data', [SekolahController::class, 'data'])->name('sekolah.data')->middleware('rbac:perumusan_tujuan');
Route::get('/sekolah/dataArsip', [SekolahController::class, 'dataArsip'])->name('sekolah.dataArsip')->middleware('rbac:perumusan_tujuan');
Route::post('/sekolah/store', [SekolahController::class, 'store'])->name('sekolah.store')->middleware('rbac:perumusan_tujuan,2');
Route::patch('/sekolah/update', [SekolahController::class, 'update'])->name('sekolah.update')->middleware('rbac:perumusan_tujuan,3');
Route::patch('/sekolah/archive', [SekolahController::class, 'archive'])->name('sekolah.archive')->middleware('rbac:perumusan_tujuan,3');
Route::patch('/sekolah/unarchive', [SekolahController::class, 'unarchive'])->name('sekolah.unarchive')->middleware('rbac:perumusan_tujuan,3');
Route::delete('/sekolah/delete', [SekolahController::class, 'delete'])->name('sekolah.delete')->middleware('rbac:perumusan_tujuan,4');
Route::get('/sekolah/blueprint/{encrypted_id}', [SekolahController::class, 'blueprint'])->name('sekolah.blueprint')->middleware('rbac:perumusan_tujuan');
Route::get('/sekolah/rubrik/{encrypted_id}', [SekolahController::class, 'rubrik'])->name('sekolah.rubrik')->middleware('rbac:perumusan_tujuan');
Route::get('/sekolah/getSelectedMateriMatpel/{encrypted_id}', [SekolahController::class, 'getSelectedMateriMatpel'])->name('sekolah.getSelectedMateriMatpel')->middleware('rbac:perumusan_tujuan');

// Autosave (Update Custom)
Route::post('/blueprint/update_custom', [BlueprintController::class, 'update_custom'])->name('blueprint.update_custom')->middleware('rbac:perumusan_tujuan');

// Blueprint
Route::get('/blueprint/data', [BlueprintController::class, 'data'])->name('blueprint.data')->middleware('rbac:perumusan_tujuan');
Route::get('/blueprint/kognitif/{encrypted_id}', [BlueprintController::class, 'kognitif'])->name('blueprint.kognitif')->middleware('rbac:perumusan_tujuan');
Route::get('/blueprint/afektif/{encrypted_id}', [BlueprintController::class, 'afektif'])->name('blueprint.afektif')->middleware('rbac:perumusan_tujuan');
Route::get('/blueprint/psikomotorik/{encrypted_id}', [BlueprintController::class, 'psikomotorik'])->name('blueprint.psikomotorik')->middleware('rbac:perumusan_tujuan');

// Materi Bleuprint
Route::get('/blueprint/materi', [BlueprintController::class, 'materi'])->name('blueprint.materi')->middleware('rbac:perumusan_tujuan');
Route::post('/blueprint/materi_store', [BlueprintController::class, 'materi_store'])->name('blueprint.materi_store')->middleware('rbac:perumusan_tujuan,2');
Route::delete('/blueprint/materi_delete', [BlueprintController::class, 'materi_delete'])->name('blueprint.materi_delete')->middleware('rbac:perumusan_tujuan,4');

// Indikator Blueprint
Route::post('/blueprint/target_store', [BlueprintController::class, 'target_store'])->name('blueprint.target_store')->middleware('rbac:perumusan_tujuan,2');
Route::delete('/blueprint/target_delete', [BlueprintController::class, 'target_delete'])->name('blueprint.target_delete')->middleware('rbac:perumusan_tujuan,4');

// Download PDF Blueprint
Route::get('/blueprint/download/{encrypted_id}', [BlueprintController::class, 'download'])->name('blueprint.download')->middleware('rbac:perumusan_tujuan');

// Rubrik
Route::get('/rubrik/data', [RubrikController::class, 'data'])->name('rubrik.data')->middleware('rbac:perumusan_tujuan');
Route::get('/rubrik/kognitif/{encrypted_id}', [RubrikController::class, 'kognitif'])->name('rubrik.kognitif')->middleware('rbac:perumusan_tujuan');
Route::get('/rubrik/afektif/{encrypted_id}', [RubrikController::class, 'afektif'])->name('rubrik.afektif')->middleware('rbac:perumusan_tujuan');
Route::get('/rubrik/psikomotorik/{encrypted_id}', [RubrikController::class, 'psikomotorik'])->name('rubrik.psikomotorik')->middleware('rbac:perumusan_tujuan');

// Materi Rubrik
Route::get('/rubrik/materi', [RubrikController::class, 'materi'])->name('rubrik.materi')->middleware('rbac:perumusan_tujuan');

// Download PDF Rubrik
Route::get('/rubrik/download/{encrypted_id}', [RubrikController::class, 'download'])->name('rubrik.download')->middleware('rbac:perumusan_tujuan');
