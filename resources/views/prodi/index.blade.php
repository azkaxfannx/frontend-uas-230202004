@extends('layouts.app')
@section('title', 'Data Prodi')
@section('content')
    <h3>Data Prodi</h3>
    <a href="/prodi/create" class="btn btn-primary mb-3">Tambah Prodi</a>

    <input type="text" id="search" class="form-control mb-3" placeholder="Cari berdasarkan Kode/Nama ....">

    <table class="table table-bordered" id="prodiTable">
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

    @section('scripts')
        <script>
            $('#search').on('keyup', function () {
                let value = $(this).val().toLowerCase().trim();
                $('#prodiTable tbody tr').filter(function () {
                    let kode_prodi = $(this).find('td').eq(0).text().toLowerCase().trim();
                    let nama_prodi = $(this).find('td').eq(1).text().toLowerCase().trim();
                    $(this).toggle(kode_prodi.startsWith(value) || nama_prodi.startsWith(value));
                });
            });
        </script>
    @endsection
@endsection