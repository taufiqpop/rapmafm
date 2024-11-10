<?php

use App\Http\Controllers\MateriMatpelController;

Route::get('/', [MateriMatpelController::class, 'index'])->name('materi_matpel')->middleware('rbac:materi_matpel');
Route::get('/data', [MateriMatpelController::class, 'data'])->name('materi_matpel.data')->middleware('rbac:materi_matpel');
Route::post('/store', [MateriMatpelController::class, 'store'])->name('materi_matpel.store')->middleware('rbac:materi_matpel,2');
Route::patch('/update', [MateriMatpelController::class, 'update'])->name('materi_matpel.update')->middleware('rbac:materi_matpel,3');
Route::delete('/delete', [MateriMatpelController::class, 'delete'])->name('materi_matpel.delete')->middleware('rbac:materi_matpel,4');
