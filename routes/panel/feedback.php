<?php

use App\Http\Controllers\FeedbackController;

// Data
Route::get('/', [FeedbackController::class, 'index'])->name('feedback')->middleware('rbac:feedback');
Route::get('/data', [FeedbackController::class, 'data'])->name('feedback.data')->middleware('rbac:feedback');
Route::get('/edit/{encrypted_id}', [FeedbackController::class, 'edit'])->name('feedback.edit')->middleware('rbac:feedback');
Route::get('/form', [FeedbackController::class, 'form'])->name('feedback.form')->middleware('rbac:feedback');

// Autosave
Route::post('/feedback/update_custom', [FeedbackController::class, 'update_custom'])->name('feedback.update_custom')->middleware('rbac:feedback');

// Download Feedback
Route::get('/downloadFeedback/{encrypted_id}', [FeedbackController::class, 'downloadFeedback'])->name('feedback.downloadFeedback')->middleware('rbac:feedback');
