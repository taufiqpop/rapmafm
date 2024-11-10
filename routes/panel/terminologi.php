<?php

use App\Http\Controllers\TerminologiController;

Route::get('/', [TerminologiController::class, 'index'])->name('terminologi')->middleware('rbac:terminologi');
Route::get('/data', [TerminologiController::class, 'data'])->name('terminologi.data')->middleware('rbac:terminologi');
Route::post('/store', [TerminologiController::class, 'store'])->name('terminologi.store')->middleware('rbac:terminologi,2');
Route::patch('/update', [TerminologiController::class, 'update'])->name('terminologi.update')->middleware('rbac:terminologi,3');
Route::delete('/delete', [TerminologiController::class, 'delete'])->name('terminologi.delete')->middleware('rbac:terminologi,4');
