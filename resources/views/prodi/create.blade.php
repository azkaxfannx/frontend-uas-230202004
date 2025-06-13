@extends('layouts.app')
@section('title', 'Tambah Prodi')
@section('content')
<h3>Tambah Prodi</h3>
<form method="POST" action="/prodi">
    @csrf
    <div class="mb-3">
        <label>Kode Prodi</label>
        <input type="text" name="nidn" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Nama Prodi</label>
        <input type="text" name="nama" class="form-control" required>
    </div>
    <a href="/prodi" class="btn btn-warning">Kembali</a>
    <button class="btn btn-success">Simpan</button>
</form>
@endsection