<?php

use App\Http\Controllers\Kepenyiaran\RefJenisProgramSiarController;

Route::get('/', [RefJenisProgramSiarController::class, 'index'])->name('ref-jenis-program-siar')->middleware('rbac:program_siar');
Route::get('/data', [RefJenisProgramSiarController::class, 'data'])->name('ref-jenis-program-siar.data')->middleware('rbac:program_siar');
Route::post('/store', [RefJenisProgramSiarController::class, 'store'])->name('ref-jenis-program-siar.store')->middleware('rbac:program_siar,2');
Route::patch('/update', [RefJenisProgramSiarController::class, 'update'])->name('ref-jenis-program-siar.update')->middleware('rbac:program_siar,3');
Route::delete('/delete', [RefJenisProgramSiarController::class, 'delete'])->name('ref-jenis-program-siar.delete')->middleware('rbac:program_siar,4');
