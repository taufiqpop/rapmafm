<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::any('/', function () {
    return redirect(route('login'));
});
Route::any('/afel', function () {
    return redirect(route('login'));
});
// Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('/register', 'Auth\RegisterController@register');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/check-access', [HomeController::class, 'rbacCheck'])->name('check-access');
Route::post('/check-access', [HomeController::class, 'chooseRole'])->name('choose-role');
Route::get('/menus', [HomeController::class, 'loadMenu'])->name('load-menu');

// Route::middleware('auth')->group(function () {
//     Route::prefix('dashboard')->group(function () {
//     });

//     Route::prefix('users')->group(function () {
//     });

//     Route::prefix('manajemen-menu')->group(function () {
//     });

//     Route::prefix('otoritas')->group(function () {
//     });
// });
