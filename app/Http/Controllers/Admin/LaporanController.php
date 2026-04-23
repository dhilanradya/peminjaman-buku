<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['user', 'book'])
                    ->latest('tgl_kembali_actual');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', fn($user) => $user->where('nama', 'like', "%$search%"))
                  ->orWhereHas('book', fn($book) => $book->where('judul', 'like', "%$search%"));
            });
        }

        if ($request->filled('status_denda')) {
            $query->where('status_denda', $request->status_denda);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', 'Dikembalikan');
        }

        // Filter Tanggal
        if ($request->filled('tanggal_awal')) {
            $query->whereDate('tgl_pinjam', '>=', $request->tanggal_awal);
        }
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tgl_pinjam', '<=', $request->tanggal_akhir);
        }

        $laporan = $query->paginate(15)->withQueryString();

        $totalDenda = (clone $query)->sum('denda');

        return view('admin.laporan', compact('laporan', 'totalDenda'));
    }

    // ==================== EXPORT EXCEL (CSV) ====================
    public function exportExcel(Request $request)
{
    $query = Peminjaman::with(['user', 'book'])
                ->where('status', 'Dikembalikan')
                ->latest('tgl_kembali_actual');

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->whereHas('user', fn($u) => $u->where('nama', 'like', "%$search%"))
              ->orWhereHas('book', fn($b) => $b->where('judul', 'like', "%$search%"));
        });
    }

    if ($request->filled('tanggal_awal')) {
        $query->whereDate('tgl_pinjam', '>=', $request->tanggal_awal);
    }
    if ($request->filled('tanggal_akhir')) {
        $query->whereDate('tgl_pinjam', '<=', $request->tanggal_akhir);
    }

    $laporan = $query->get();

    // ✅ Hitung total denda
    $totalDenda = $laporan->sum('denda');

    $filename = 'laporan_pengembalian_' . date('Ymd_His') . '.csv';

    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => "attachment; filename=\"$filename\"",
    ];

    $callback = function() use ($laporan, $totalDenda) {
        $file = fopen('php://output', 'w');

        // Header
        fputcsv($file, [
            'No', 'Nama Siswa', 'Kelas', 'Buku', 'Jumlah',
            'Tanggal Pinjam', 'Batas Kembali', 'Tanggal Dikembalikan', 'Denda'
        ]);

        // Data
        foreach ($laporan as $index => $p) {
            fputcsv($file, [
                $index + 1,
                $p->user->nama ?? 'N/A',
                $p->user->kelas ?? '-',
                $p->book->judul,
                $p->jumlah,
                $p->tgl_pinjam,
                $p->tgl_kembali,
                $p->tgl_kembali_actual ?? '-',
                'Rp ' . number_format($p->denda, 0, ',', '.')
            ]);
        }

        // ✅ Baris kosong
        fputcsv($file, []);

        // ✅ Total Denda
        fputcsv($file, [
            '', '', '', '', '', '', '', 'Total Denda',
            'Rp ' . number_format($totalDenda, 0, ',', '.')
        ]);

        fclose($file);
    };

    return Response::stream($callback, 200, $headers);
}

    // ==================== EXPORT PDF (Sederhana) ====================
    public function exportPdf(Request $request)
    {
        $query = Peminjaman::with(['user', 'book'])
                    ->where('status', 'Dikembalikan')
                    ->latest('tgl_kembali_actual');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', fn($u) => $u->where('nama', 'like', "%$search%"))
                  ->orWhereHas('book', fn($b) => $b->where('judul', 'like', "%$search%"));
            });
        }

        if ($request->filled('tanggal_awal')) $query->whereDate('tgl_pinjam', '>=', $request->tanggal_awal);
        if ($request->filled('tanggal_akhir')) $query->whereDate('tgl_pinjam', '<=', $request->tanggal_akhir);

        $laporan = $query->get();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.laporan_pdf', compact('laporan'));

        return $pdf->download('laporan_pengembalian_' . date('Ymd_His') . '.pdf');
    }
}
