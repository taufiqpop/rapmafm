<?php

use App\Http\Controllers\KerjaBaktiController;

Route::get('/', [KerjaBaktiController::class, 'index'])->name('kerja-bakti')->middleware('rbac:kerja_bakti');
Route::get('/data', [KerjaBaktiController::class, 'data'])->name('kerja-bakti.data')->middleware('rbac:kerja_bakti');
Route::post('/store', [KerjaBaktiController::class, 'store'])->name('kerja-bakti.store')->middleware('rbac:kerja_bakti,2');
Route::patch('/update', [KerjaBaktiController::class, 'update'])->name('kerja-bakti.update')->middleware('rbac:kerja_bakti,3');
Route::delete('/delete', [KerjaBaktiController::class, 'delete'])->name('kerja-bakti.delete')->middleware('rbac:kerja_bakti,4');
