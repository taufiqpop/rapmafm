<?php

use App\Http\Controllers\MonitoringController;

// Data
Route::get('/', [MonitoringController::class, 'index'])->name('monitoring')->middleware('rbac:monitoring_peserta_didik');
Route::get('/data', [MonitoringController::class, 'data'])->name('monitoring.data')->middleware('rbac:monitoring_peserta_didik');
Route::get('/edit/{encrypted_id}', [MonitoringController::class, 'edit'])->name('monitoring.edit')->middleware('rbac:monitoring_peserta_didik');

// Autosave
Route::post('/monitoring/update_custom', [MonitoringController::class, 'update_custom'])->name('monitoring.update_custom')->middleware('rbac:monitoring_peserta_didik');

// Download Monitoring
Route::get('/downloadMonitoring/{encrypted_id}', [MonitoringController::class, 'downloadMonitoring'])->name('monitoring.downloadMonitoring')->middleware('rbac:monitoring_peserta_didik');
