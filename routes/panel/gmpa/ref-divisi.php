<?php

use App\Http\Controllers\GMPA\RefDivisiController;

Route::get('/', [RefDivisiController::class, 'index'])->name('divisi')->middleware('rbac:ref_divisi');
Route::get('/data', [RefDivisiController::class, 'data'])->name('divisi.data')->middleware('rbac:ref_divisi');
Route::post('/store', [RefDivisiController::class, 'store'])->name('divisi.store')->middleware('rbac:ref_divisi,2');
Route::patch('/update', [RefDivisiController::class, 'update'])->name('divisi.update')->middleware('rbac:ref_divisi,3');
Route::delete('/delete', [RefDivisiController::class, 'delete'])->name('divisi.delete')->middleware('rbac:ref_divisi,4');
