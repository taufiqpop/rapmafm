<?php

use App\Http\Controllers\Kepenyiaran\TopChartsController;

Route::get('/', [TopChartsController::class, 'index'])->name('top-charts')->middleware('rbac:top_charts');
Route::get('/data', [TopChartsController::class, 'data'])->name('top-charts.data')->middleware('rbac:top_charts');
Route::post('/store', [TopChartsController::class, 'store'])->name('top-charts.store')->middleware('rbac:top_charts,2');
Route::patch('/update', [TopChartsController::class, 'update'])->name('top-charts.update')->middleware('rbac:top_charts,3');
Route::delete('/delete', [TopChartsController::class, 'delete'])->name('top-charts.delete')->middleware('rbac:top_charts,4');
