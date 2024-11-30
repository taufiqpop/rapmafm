<?php

use App\Http\Controllers\Kepenyiaran\PodcastController;

Route::get('/', [PodcastController::class, 'index'])->name('podcast')->middleware('rbac:podcast');
Route::get('/data', [PodcastController::class, 'data'])->name('podcast.data')->middleware('rbac:podcast');
Route::post('/store', [PodcastController::class, 'store'])->name('podcast.store')->middleware('rbac:podcast,2');
Route::patch('/update', [PodcastController::class, 'update'])->name('podcast.update')->middleware('rbac:podcast,3');
Route::delete('/delete', [PodcastController::class, 'delete'])->name('podcast.delete')->middleware('rbac:podcast,4');
Route::get('/getProgramSiar/{jenis_program_id}', [PodcastController::class, 'getProgramSiar'])->middleware('rbac:podcast');
