<?php

use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Login;
use App\Http\Controllers\Mahasiswa;
use App\Http\Controllers\Prodi;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', [Login::class, 'showLoginForm'])->name('login');
Route::post('/login', [Login::class, 'login']);
Route::post('/logout', [Login::class, 'logout'])->name('logout');

Route::middleware(['auth.session'])->group(function () {
    Route::get('/', [Dashboard::class, 'index']);
    Route::resource('prodi', Prodi::class);
    Route::get('/mahasiswa/export', [Mahasiswa::class, 'export']);
    Route::resource('mahasiswa', Mahasiswa::class)->except(['show']);
});