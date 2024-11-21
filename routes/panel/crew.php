<?php

use App\Http\Controllers\CrewController;

Route::get('/', [CrewController::class, 'index'])->name('crew')->middleware('rbac:crew');
Route::get('/data', [CrewController::class, 'data'])->name('crew.data')->middleware('rbac:crew');
Route::post('/store', [CrewController::class, 'store'])->name('crew.store')->middleware('rbac:crew,2');
Route::patch('/update', [CrewController::class, 'update'])->name('crew.update')->middleware('rbac:crew,3');
Route::delete('/delete', [CrewController::class, 'delete'])->name('crew.delete')->middleware('rbac:crew,4');
Route::patch('/switch', [CrewController::class, 'switchStatus'])->name('crew.switch')->middleware('rbac:crew,3');
