@extends('layouts.app')
@section('title', 'Data Mahasiswa')
@section('content')
    <h3>Data Mahasiswa</h3>
    <a href="/mahasiswa/create" class="btn btn-primary mb-3">Tambah Mahasiswa</a>

    <a href="/mahasiswa/export" class="btn btn-success mb-3 ms-2">Export PDF</a>

    <input type="text" id="search" class="form-control mb-3" placeholder="Cari berdasarkan NPM/Nama ....">

    <table class="table table-bordered" id="mhsTable">
        <thead>
            <tr>
                <th>NPM</th>
                <th>Nama</th>
                <th>ID Kelas</th>
                <th>Kode Prodi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item['npm'] }}</td>
                    <td>{{ $item['nama_mahasiswa'] }}</td>
                    <td>{{ $item['id_kelas'] }}</td>
                    <td>{{ $item['kode_prodi'] }}</td>
                    <td>
                        <a href="/mahasiswa/{{ $item['npm'] }}/edit" class="btn btn-sm btn-warning">Edit</a>
                        <form action="/mahasiswa/{{ $item['npm'] }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

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
@endsection