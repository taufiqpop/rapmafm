<?php

use App\Http\Controllers\Marketing\EventsController;

Route::get('/', [EventsController::class, 'index'])->name('events')->middleware('rbac:events');
Route::get('/data', [EventsController::class, 'data'])->name('events.data')->middleware('rbac:events');
Route::post('/store', [EventsController::class, 'store'])->name('events.store')->middleware('rbac:events,2');
Route::patch('/update', [EventsController::class, 'update'])->name('events.update')->middleware('rbac:events,3');
Route::delete('/delete', [EventsController::class, 'delete'])->name('events.delete')->middleware('rbac:events,4');
Route::patch('/switch', [EventsController::class, 'switchStatus'])->name('events.switch')->middleware('rbac:events,3');
