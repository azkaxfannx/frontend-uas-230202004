# Demo: `http://uas-azka.duckdns.org/`
## Login:
### `admin@example.com` | `123456`

# Laravel Frontend Setup Guide

Panduan lengkap untuk setup Laravel sebagai frontend yang mengkonsumsi API dari backend.

## 📋 Persiapan Awal

### 1. Install Laravel
```bash
composer create-project "laravel/laravel:^10.0" frontend-uas-230202004
```
> Membuat folder dengan nama `frontend-uas-230202004`

### 2. Masuk ke VSCode
```bash
cd frontend-uas-230202004
code .
```

### 3. Install Dependencies
Jalankan di cmd yang tadi:

#### Sesuai dokumentasi Laravel:
```bash
npm install && npm run build
composer run dev
```

## ⚙️ Konfigurasi Environment

### 4. Ubah Session Driver
Edit file `.env` dan ubah:
```env
SESSION_DRIVER=file
```

### 5. Tambahkan API Base URL
Tambahkan di file `.env`:
```env
BACKEND_URL=http://localhost:8080
```

### 6. Konfigurasi Services
Edit file `config/services.php` dan tambahkan:
```php
'backend' => [
    'base_url' => env('BACKEND_URL', 'http://localhost:8080'),
],
```

## 🎛️ Membuat Controllers

### 7. Generate Controllers
```bash
php artisan make:controller Mahasiswa
php artisan make:controller Prodi
php artisan make:controller Dashboard
```

### 8. Buat Function untuk CRUD di Controller Mahasiswa dan Prodi. Contoh:
```php
<?php

namespace App\Http\Controllers;

use App\Services\MahasiswaServices;
use App\Services\ProdiServices;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class Mahasiswa extends Controller
{
    protected $mahasiswa;
    protected $prodi;

    public function __construct(MahasiswaServices $mahasiswa, ProdiServices $prodi)
    {
        $this->mahasiswa = $mahasiswa;
        $this->prodi = $prodi;
    }

    public function index()
    {
        $data = $this->mahasiswa->getAll();
        return view('mahasiswa.index', compact('data'));
    }

// ...
```

### 9. Buat juga folder `Services` dan buat file MahasiswaServices & ProdiServices (agar kode lebih clean dan mudah dimaintain). Contoh isi file:
```php
<?php 

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MahasiswaServices
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.backend.base_url');
    }

    public function getAll()
    {
        $response = Http::get("{$this->baseUrl}/mahasiswa");
        return $response->successful() ? $response->json() : [];
    }
// ...
```

## 📁 Struktur Views

### 10. Buat Folder dan File Views
```
resources/
├── views/
    ├── layouts/
    │   └── app.blade.php
    ├── mahasiswa/
    │   ├── index.blade.php
    │   ├── create.blade.php
    │   └── edit.blade.php
    └── prodi/
    │   ├── index.blade.php
    │   ├── create.blade.php
    │   └── edit.blade.php
    ├── dashboard.blade.php
```

## 🚀 Menjalankan Aplikasi

### 11. Start Development Server
```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

## 📌 Catatan Penting

- Pastikan API backend sudah berjalan di `http://localhost:8080`
- Gunakan `@csrf` token untuk semua form POST/PUT/DELETE
- Gunakan `@method('PUT')` dan `@method('DELETE')` untuk HTTP methods selain GET/POST
- Implementasikan error handling yang proper untuk response API
- Tambahkan validasi form sesuai kebutuhan

# Laravel PDF Export Guide

Panduan lengkap untuk export PDF di Laravel menggunakan package **barryvdh/laravel-dompdf**.

## 📦 Instalasi Package

### 1. Install via Composer
```bash
composer require barryvdh/laravel-dompdf
```

## 🎯 Implementasi Dasar

### 2. Tambahkan Method di Controller Mahasiswa
```php
use Barryvdh\DomPDF\Facade\Pdf;

public function export() {
        $data = $this->mahasiswa->getAll();
        $pdf = Pdf::loadView('mahasiswa.pdf', compact('data'));
        return $pdf->download('data-mahasiswa.pdf');
    }
```

### 3. Buat Template PDF
Buat file `resources/views/mahasiswa/pdf.blade.php`:

```html
<html>
<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h3>Data Mahasiswa</h3>
    <table>
        <thead>
            <tr>
                <th>NPM</th>
                <th>Nama</th>
                <th>ID Kelas</th>
                <th>Kode Prodi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item['npm'] }}</td>
                    <td>{{ $item['nama_mahasiswa'] }}</td>
                    <td>{{ $item['id_kelas'] }}</td>
                    <td>{{ $item['kode_prodi'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
```

### 4. Tambahkan Button di View
Di `resources/views/mahasiswa/index.blade.php`:

```html
<a href="/mahasiswa/export" class="btn btn-success mb-3 ms-2">Export PDF</a>
```

Dengan klik button export PDF, kalian bisa export data di tabel mahasiswa menjadi format PDF.

# Simulasi Login (Dummy)

## 🎯 Implementasi Dasar

### 1. Buat Controller Login
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Login extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        if ($email === 'admin@example.com' && $password === '123456') {
            Session::put('logged_in', true);
            return redirect('/')->with('success', 'Login berhasil');
        }

        return redirect('/login')->with('error', 'Email atau password salah');
    }

    public function logout()
    {
        Session::forget('logged_in');
        return redirect('/login')->with('success', 'Berhasil logout');
    }
}
```

### 2. Buat AuthSession di Middleware
Buat file `app/Middleware/AuthSession.php`:

```php
<?php 

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class AuthSession
{
    public function handle($request, Closure $next)
    {
        if (!Session::get('logged_in')) {
            return redirect('/login')->with('error', 'Silakan login dulu.');
        }
        return $next($request);
    }
}
```

### 3. Daftarkan di Kernel
Tambahkan ke `app/Kernel.php` bagian $middlewareAliases:

```php
'auth.session' => \App\Http\Middleware\AuthSession::class
```

### 4. Atur routes jadi seperti ini
Di `routes/web.php`:

```php
<?php

use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Login;
use App\Http\Controllers\Mahasiswa;
use App\Http\Controllers\Prodi;
use Illuminate\Support\Facades\Route;

Route::get('/login', [Login::class, 'showLoginForm'])->name('login');
Route::post('/login', [Login::class, 'login']);
Route::post('/logout', [Login::class, 'logout'])->name('logout');

Route::middleware(['auth.session'])->group(function () {
    Route::get('/', [Dashboard::class, 'index']);
    Route::resource('prodi', Prodi::class);
    Route::get('/mahasiswa/export', [Mahasiswa::class, 'export']);
    Route::resource('mahasiswa', Mahasiswa::class)->except(['show']);
});
```

### 5. Atur layouts.app jadi seperti ini
Di `views/layouts/app.blade.php`:

```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="/">Dashboard</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="/prodi">Prodi</a></li>
                <li class="nav-item"><a class="nav-link" href="/mahasiswa">Mahasiswa</a></li>
                @if(Session::get('logged_in'))
                    <li class="nav-item">
                        <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endif
            </ul>
        </div>
    </div>
    </nav>
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @yield('content')
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    $(document).ready(function() {
        window.setTimeout(function() {
            $('.alert').fadeTo(500, 0).slideUp(500, function(){
                $(this).remove();
                });
            }, 2000);
        });
    </script>
    @yield('scripts')
</body>
</html>
```

### 6. Buat tampilan login
Di `views/auth/login.blade.php`:

```html
@extends('layouts.auth')
@section('title', 'Login')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Login</div>
            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <form method="POST" action="/login">
                    @csrf
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button class="btn btn-primary w-100">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
```

Sekarang sudah bisa login dan sistem akan memverifikasi session. Jika tidak valid, maka langsung terlempar ke halaman login.

# Fitur Search (JQuery)

Panduan lengkap untuk membuat fitur search dengan JQuery.

## 🎯 Implementasi Dasar

### 1. Edit layouts.app seperti langkah di atas

### 2. Tambahkan ini di masing-masing file index

```html
<input type="text" id="search" class="form-control mb-3" placeholder="Cari berdasarkan NPM/Nama ....">

@section('scripts')
        <script>
            $('#search').on('keyup', function () {
                let value = $(this).val().toLowerCase().trim();
                $('#mhsTable tbody tr').filter(function () {
                    let npm = $(this).find('td').eq(0).text().toLowerCase().trim();
                    let nama = $(this).find('td').eq(1).text().toLowerCase().trim();
                    $(this).toggle(npm.startsWith(value) || nama.startsWith(value));
                });
            });
        </script>
    @endsection
```

Edit juga bagian tabel masing-masing (berikan id) untuk bisa dimanipulasi dom dari script.

Dengan begitu, kalian sudah bisa membuat fitur search realtime.

## 📝 Kesimpulan

Dengan mengikuti panduan ini, kalian bisa:

- ✅ Export data ke PDF
- ✅ Membuat simulasi login by session
- ✅ Membuat fitur search realtime
