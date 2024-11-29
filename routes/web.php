<?php

use App\Http\Controllers\FrontController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', [FrontController::class, 'index'])->name('rapmafm');
Route::post('/send', [FrontController::class, 'send'])->name('message.send');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/check-access', [HomeController::class, 'rbacCheck'])->name('check-access');
Route::post('/check-access', [HomeController::class, 'chooseRole'])->name('choose-role');
Route::get('/menus', [HomeController::class, 'loadMenu'])->name('load-menu');
