<!DOCTYPE html>
<html>
<head>
    <title>Laporan Perkembangan Anak</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid black; padding: 5px; }
    </style>
</head>
<body>
    <h3>Laporan Perkembangan Anak</h3>
    <table>
        <thead>
            <tr>
                <th>Nama Anak</th>
                <th>Usia</th>
                <th>Jenis Kelamin</th>
                <th>Diagnosis</th>
                <th>Nilai Z</th>
                <th>Rekomendasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td>{{ $item->nama_anak }}</td>
                <td>{{ $item->usia }}</td>
                <td>{{ $item->jenis_kelamin }}</td>
                <td>{{ $item->kategori }}</td>
                <td>{{ $item->nilai_z }}</td>
                <td>{{ $item->rekomendasi }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
