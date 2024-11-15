<?php

use App\Http\Controllers\ProgramSiarController;

Route::get('/', [ProgramSiarController::class, 'index'])->name('program-siar')->middleware('rbac:program_siar');
Route::get('/data', [ProgramSiarController::class, 'data'])->name('program-siar.data')->middleware('rbac:program_siar');
Route::post('/store', [ProgramSiarController::class, 'store'])->name('program-siar.store')->middleware('rbac:program_siar,2');
Route::patch('/update', [ProgramSiarController::class, 'update'])->name('program-siar.update')->middleware('rbac:program_siar,3');
Route::delete('/delete', [ProgramSiarController::class, 'delete'])->name('program-siar.delete')->middleware('rbac:program_siar,4');
Route::patch('/switch', [ProgramSiarController::class, 'switchStatus'])->name('program-siar.switch')->middleware('rbac:program_siar,3');
Route::get('/getProgramSiar/{jenis_program_id}', [ProgramSiarController::class, 'getProgramSiar'])->middleware('rbac:program_siar');
