<?php

use App\Http\Controllers\GMPA\SuratController;

Route::get('/', [SuratController::class, 'index'])->name('surat')->middleware('rbac:surat');
Route::get('/data', [SuratController::class, 'data'])->name('surat.data')->middleware('rbac:surat');
Route::post('/store', [SuratController::class, 'store'])->name('surat.store')->middleware('rbac:surat,2');
Route::patch('/update', [SuratController::class, 'update'])->name('surat.update')->middleware('rbac:surat,3');
Route::delete('/delete', [SuratController::class, 'delete'])->name('surat.delete')->middleware('rbac:surat,4');
