@extends('layouts.app')
@section('title', 'Tambah Mahasiswa')
@section('content')
<h3>Tambah Mahasiswa</h3>
<form method="POST" action="/mahasiswa">
    @csrf
    <div class="mb-3">
        <label>NPM</label>
        <input type="text" name="npm" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Nama</label>
        <input type="text" name="nama" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>ID Kelas</label>
        <input type="text" name="id_kelas" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Kode Prodi</label>
        <select name="kode_prodi" class="form-control">
            <option value="">- Tidak ada -</option>
            @foreach ($prodi as $p)
                <option value="{{ $p['kode_prodi'] }}">{{ $p['nama_prodi'] }}</option>
            @endforeach
        </select>
    </div>
    <a href="/mahasiswa" class="btn btn-warning">Kembali</a>
    <button class="btn btn-success">Simpan</button>
</form>
@endsection