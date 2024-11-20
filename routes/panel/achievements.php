<?php

use App\Http\Controllers\AchievementsController;

Route::get('/', [AchievementsController::class, 'index'])->name('achievements')->middleware('rbac:achievements');
Route::get('/data', [AchievementsController::class, 'data'])->name('achievements.data')->middleware('rbac:achievements');
Route::post('/store', [AchievementsController::class, 'store'])->name('achievements.store')->middleware('rbac:achievements,2');
Route::patch('/update', [AchievementsController::class, 'update'])->name('achievements.update')->middleware('rbac:achievements,3');
Route::delete('/delete', [AchievementsController::class, 'delete'])->name('achievements.delete')->middleware('rbac:achievements,4');
