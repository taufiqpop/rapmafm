<?php

use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware('rbac:beranda');
