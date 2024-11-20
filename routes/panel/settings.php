<?php

use App\Http\Controllers\SettingsController;

Route::get('/', [SettingsController::class, 'index'])->name('settings')->middleware('rbac:settings');
Route::post('/update_custom', [SettingsController::class, 'update_custom'])->name('settings.update_custom')->middleware('rbac:settings');
