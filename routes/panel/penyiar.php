<?php

use App\Http\Controllers\PenyiarController;

Route::get('/', [PenyiarController::class, 'index'])->name('penyiar')->middleware('rbac:penyiar');
Route::post('/update_custom', [PenyiarController::class, 'update_custom'])->name('penyiar.update_custom')->middleware('rbac:penyiar');
Route::get('/getProgramSiar/{jenis_program_id}', [PenyiarController::class, 'getProgramSiar'])->middleware('rbac:penyiar');
