@extends('layouts.app')
@section('title', 'Edit Mahasiswa')
@section('content')
<h3>Edit Mahasiswa</h3>
<form method="POST" action="/mahasiswa/{{ $data1['npm'] }}">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label>NPM</label>
        <input type="text" name="npm" value="{{ $data1['npm'] }}" class="form-control" required disabled>
    </div>
    <div class="mb-3">
        <label>Nama</label>
        <input type="text" name="nama" value="{{ $data1['nama_mahasiswa'] }}" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>ID Kelas</label>
        <input type="text" name="id_kelas" value="{{ $data1['id_kelas'] }}" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Kode Prodi</label>
        <select name="kode_prodi" class="form-control">
            <option value="">- Tidak ada -</option>
            @foreach ($data2 as $p)
                <option value="{{ $p['nidn'] }}" @if ($data1['kode_prodi'] == $p['kode_prodi']) selected @endif>{{ $p['nama_prodi'] }}</option>
            @endforeach
        </select>
    </div>
    <a href="/mahasiswa" class="btn btn-warning">Kembali</a>
    <button class="btn btn-primary">Update</button>
</form>
@endsection