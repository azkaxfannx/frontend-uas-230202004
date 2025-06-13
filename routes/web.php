<?php

use App\Http\Controllers\Dashboard;
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

Route::get('/', [Dashboard::class, 'index']);
// Route::get('/login', [LoginController::class, 'showLoginForm']);
// Route::post('/login', [LoginController::class, 'login']);

Route::resource('prodi', Prodi::class);
Route::resource('mahasiswa', Mahasiswa::class);