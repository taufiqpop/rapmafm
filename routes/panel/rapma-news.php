<?php

use App\Http\Controllers\RapmaNewsController;

Route::get('/', [RapmaNewsController::class, 'index'])->name('rapma-news')->middleware('rbac:rapma_news');
Route::get('/data', [RapmaNewsController::class, 'data'])->name('rapma-news.data')->middleware('rbac:rapma_news');
Route::post('/store', [RapmaNewsController::class, 'store'])->name('rapma-news.store')->middleware('rbac:rapma_news,2');
Route::patch('/update', [RapmaNewsController::class, 'update'])->name('rapma-news.update')->middleware('rbac:rapma_news,3');
Route::delete('/delete', [RapmaNewsController::class, 'delete'])->name('rapma-news.delete')->middleware('rbac:rapma_news,4');
Route::patch('/switch', [RapmaNewsController::class, 'switchStatus'])->name('rapma-news.switch')->middleware('rbac:rapma_news,3');
