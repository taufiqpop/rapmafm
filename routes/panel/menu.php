<?php

use App\Http\Controllers\MenusController;

Route::get('/', [MenusController::class, 'index'])->name('manajemen-menu')->middleware('rbac:manajemen_menu');
Route::get('/data', [MenusController::class, 'data'])->name('manajemen-menu.data')->middleware('rbac:manajemen_menu');
Route::post('/store', [MenusController::class, 'store'])->name('manajemen-menu.store')->middleware('rbac:manajemen_menu,2');
Route::patch('/update', [MenusController::class, 'update'])->name('manajemen-menu.update')->middleware('rbac:manajemen_menu,3');
Route::delete('/delete', [MenusController::class, 'delete'])->name('manajemen-menu.delete')->middleware('rbac:manajemen_menu,4');

Route::get('/get/main-menu', [MenusController::class, 'getMainMenu'])->name('manajemen-menu.get.main-menu')->middleware('rbac:manajemen_menu');
