@extends('layouts.app')
@section('title', 'Data Prodi')
@section('content')
    <h3>Data Prodi</h3>
    <a href="/prodi/create" class="btn btn-primary mb-3">Tambah Prodi</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Kode Prodi</th>
                <th>Nama Prodi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item['kode_prodi'] }}</td>
                    <td>{{ $item['nama_prodi'] }}</td>
                    <td>
                        <a href="/prodi/{{ $item['kode_prodi'] }}/edit" class="btn btn-sm btn-warning">Edit</a>
                        <form action="/prodi/{{ $item['kode_prodi'] }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection