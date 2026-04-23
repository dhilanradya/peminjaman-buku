<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengembalian</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 6px; }
        th { background-color: #f0f0f0; text-align: center; }
        h1 { text-align: center; margin-bottom: 5px; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }
    </style>
</head>
<body>

    <h1>Laporan Pengembalian Buku</h1>
    <p>Tanggal Cetak: {{ date('d M Y H:i') }}</p>

    @php
        $totalDenda = 0;
    @endphp

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
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
            @php
                $totalDenda += $p->denda;
            @endphp
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $p->user->nama ?? 'N/A' }}</td>
                <td>{{ $p->user->kelas ?? '-' }}</td>
                <td>{{ $p->book->judul }}</td>
                <td class="text-center">{{ $p->jumlah }}</td>
                <td>{{ $p->tgl_pinjam }}</td>
                <td>{{ $p->tgl_kembali }}</td>
                <td>{{ $p->tgl_kembali_actual ?? '-' }}</td>
                <td class="text-right">
                    @if($p->denda > 0)
                        Rp {{ number_format($p->denda, 0, ',', '.') }}
                    @else
                        -
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>

        <tfoot>
            <tr>
                <td colspan="8" class="text-right bold">Total Denda</td>
                <td class="text-right bold">
                    Rp {{ number_format($totalDenda, 0, ',', '.') }}
                </td>
            </tr>
        </tfoot>
    </table>

</body>
</html>
