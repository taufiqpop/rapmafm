<?php

use App\Http\Controllers\Umum\StrukturOrganisasiController;

Route::get('/', [StrukturOrganisasiController::class, 'index'])->name('struktur-organisasi')->middleware('rbac:struktur_organisasi');
Route::get('/data', [StrukturOrganisasiController::class, 'data'])->name('struktur-organisasi.data')->middleware('rbac:struktur_organisasi');
Route::post('/store', [StrukturOrganisasiController::class, 'store'])->name('struktur-organisasi.store')->middleware('rbac:struktur_organisasi,2');
Route::patch('/update', [StrukturOrganisasiController::class, 'update'])->name('struktur-organisasi.update')->middleware('rbac:struktur_organisasi,3');
Route::delete('/delete', [StrukturOrganisasiController::class, 'delete'])->name('struktur-organisasi.delete')->middleware('rbac:struktur_organisasi,4');
Route::patch('/switch', [StrukturOrganisasiController::class, 'switchStatus'])->name('struktur-organisasi.switch')->middleware('rbac:struktur_organisasi,3');
