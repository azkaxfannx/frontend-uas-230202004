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