<?php

use App\Http\Controllers\OtoritasController;

Route::get('/', [OtoritasController::class, 'index'])->name('otoritas')->middleware('rbac:otoritas');
Route::get('/data', [OtoritasController::class, 'data'])->name('otoritas.data')->middleware('rbac:otoritas');
Route::post('/store', [OtoritasController::class, 'store'])->name('otoritas.store')->middleware('rbac:otoritas,2');
Route::patch('/update', [OtoritasController::class, 'update'])->name('otoritas.update')->middleware('rbac:otoritas,3');
Route::delete('/delete', [OtoritasController::class, 'delete'])->name('otoritas.delete')->middleware('rbac:otoritas,4');

Route::get('/permission/{slug}', [OtoritasController::class, 'formPermission'])->name('otoritas.open.permission')->middleware('rbac:otoritas,3');
Route::patch('/permission', [OtoritasController::class, 'submitPermission'])->name('otoritas.submit.permission')->middleware('rbac:otoritas,3');
