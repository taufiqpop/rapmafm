<?php

use App\Http\Controllers\GMPA\RefSubDivisiController;

Route::get('/{id}', [RefSubDivisiController::class, 'index'])->name('subdivisi')->middleware('rbac:ref_divisi');
Route::get('/data/{id}', [RefSubDivisiController::class, 'data'])->name('subdivisi.data')->middleware('rbac:ref_divisi');
Route::post('/store/{id}', [RefSubDivisiController::class, 'store'])->name('subdivisi.store')->middleware('rbac:ref_divisi,2');
Route::patch('/update', [RefSubDivisiController::class, 'update'])->name('subdivisi.update')->middleware('rbac:ref_divisi,3');
Route::delete('/delete', [RefSubDivisiController::class, 'delete'])->name('subdivisi.delete')->middleware('rbac:ref_divisi,4');