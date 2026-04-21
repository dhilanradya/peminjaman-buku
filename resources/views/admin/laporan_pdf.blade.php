<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengembalian</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
        h1 { text-align: center; }
    </style>
</head>
<body>
    <h1>Laporan Pengembalian Buku</h1>
    <p>Tanggal Cetak: {{ date('d M Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Buku</th>
                <th>Jumlah</th>
                <th>Tgl Pinjam</th>
                <th>Batas Kembali</th>
                <th>Tgl Dikembalikan</th>
                <th>Denda</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $index => $p)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $p->user->nama ?? 'N/A' }}</td>
                <td>{{ $p->user->kelas ?? '-' }}</td>
                <td>{{ $p->book->judul }}</td>
                <td>{{ $p->jumlah }}</td>
                <td>{{ $p->tgl_pinjam }}</td>
                <td>{{ $p->tgl_kembali }}</td>
                <td>{{ $p->tgl_kembali_actual ?? '-' }}</td>
                <td>Rp {{ number_format($p->denda, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
