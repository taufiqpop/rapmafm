<?php

use App\Http\Controllers\RefProgramSiarController;

Route::get('/', [RefProgramSiarController::class, 'index'])->name('ref-program-siar')->middleware('rbac:program_siar');
Route::get('/data', [RefProgramSiarController::class, 'data'])->name('ref-program-siar.data')->middleware('rbac:program_siar');
Route::post('/store', [RefProgramSiarController::class, 'store'])->name('ref-program-siar.store')->middleware('rbac:program_siar,2');
Route::patch('/update', [RefProgramSiarController::class, 'update'])->name('ref-program-siar.update')->middleware('rbac:program_siar,3');
Route::delete('/delete', [RefProgramSiarController::class, 'delete'])->name('ref-program-siar.delete')->middleware('rbac:program_siar,4');
Route::patch('/switch', [RefProgramSiarController::class, 'switchStatus'])->name('ref-program-siar.switch')->middleware('rbac:program_siar,3');
