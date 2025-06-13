@extends('layouts.app')
@section('title', 'Edit Prodi')
@section('content')
<h3>Edit Prodi</h3>
<form method="POST" action="/prodi/{{ $prodi['kode_prodi'] }}">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label>Kode Prodi</label>
        <input type="text" name="kode_prodi" value="{{ $prodi['kode_prodi'] }}" class="form-control" required disabled>
    </div>
    <div class="mb-3">
        <label>Nama Prodi</label>
        <input type="text" name="nama" value="{{ $prodi['nama_prodi'] }}" class="form-control" required>
    </div>
    <a href="/prodi" class="btn btn-warning">Kembali</a>
    <button class="btn btn-primary">Update</button>
</form>
@endsection