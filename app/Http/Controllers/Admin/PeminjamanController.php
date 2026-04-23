<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Book;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index(Request $request)
{
    $query = Peminjaman::with(['user', 'book']);

    // Search functionality
    if ($request->search) {
        $query->whereHas('user', function($q) use ($request) {
            $q->where('nama', 'like', '%' . $request->search . '%')
              ->orWhere('kelas', 'like', '%' . $request->search . '%');
        })->orWhereHas('book', function($q) use ($request) {
            $q->where('judul', 'like', '%' . $request->search . '%');
        });
    }

    $peminjaman = $query->latest()->paginate(10)->withQueryString();

    return view('admin.dataPeminjaman', compact('peminjaman'));
}


    // Terima Peminjaman
    // Terima Peminjaman
public function terima(Peminjaman $peminjaman)
{
    if ($peminjaman->status !== 'Menunggu') {
        return back()->with('error', 'Status sudah diproses!');
    }

    $book = $peminjaman->book;

    if ($book->stok < $peminjaman->jumlah) {
        return back()->with('error', 'Stok buku tidak mencukupi!');
    }

    $book->decrement('stok', $peminjaman->jumlah); // sesuaikan jumlah
    $peminjaman->update([
        'status' => 'Diterima',
        'tgl_pinjam' => now()->toDateString()
    ]);

    return back()->with('success', 'Peminjaman berhasil diterima. Stok buku berkurang.');
}

// Admin/PeminjamanController.php
public function indexPengembalian(Request $request)
{
    $query = Peminjaman::with(['user', 'book'])
                    ->whereIn('status', ['Menunggu Pengembalian', 'Dikembalikan']);

    // Search functionality
    if ($request->search) {
        $query->whereHas('user', function($q) use ($request) {
            $q->where('nama', 'like', '%' . $request->search . '%')
              ->orWhere('kelas', 'like', '%' . $request->search . '%');
        })->orWhereHas('book', function($q) use ($request) {
            $q->where('judul', 'like', '%' . $request->search . '%');
        });
    }

    $pengembalian = $query->latest()->paginate(10)->withQueryString();

    return view('admin.dataPengembalian', compact('pengembalian'));
}

public function terimaKembali(Peminjaman $peminjaman)
{
    if ($peminjaman->status !== 'Menunggu Pengembalian') {
        return back()->with('error', 'Status tidak valid!');
    }

    $tglKembaliActual = now()->toDateString();
    $tglBatas         = \Carbon\Carbon::parse($peminjaman->tgl_kembali);
    $tglActual        = \Carbon\Carbon::parse($tglKembaliActual);

    $denda = 0;
    if ($tglActual->gt($tglBatas)) {
        $telat = $tglBatas->diffInDays($tglActual);
        $denda = $telat * 1000;
    }

    $peminjaman->book->increment('stok', $peminjaman->jumlah);

    $peminjaman->update([
        'status'             => 'Dikembalikan',
        'tgl_kembali_actual' => $tglKembaliActual,
        'denda'              => $denda,
        'status_denda'       => $denda > 0 ? 'Belum Dibayar' : 'Tidak Ada Denda', // ← tambah
    ]);

    return back()->with('success', 'Pengembalian dikonfirmasi!' . ($denda > 0 ? ' Denda: Rp ' . number_format($denda, 0, ',', '.') : ' Tidak ada denda.'));
}
public function indexDenda(Request $request)
{
    $query = Peminjaman::with(['user', 'book'])
                ->where('denda', '>', 0)
                ->whereIn('status_denda', ['Belum Dibayar', 'Sudah Dibayar']);

    if ($request->search) {
        $query->whereHas('user', function($q) use ($request) {
            $q->where('nama', 'like', '%' . $request->search . '%')
              ->orWhere('kelas', 'like', '%' . $request->search . '%');
        })->orWhereHas('book', function($q) use ($request) {
            $q->where('judul', 'like', '%' . $request->search . '%');
        });
    }

    if ($request->status_denda) {
        $query->where('status_denda', $request->status_denda);
    }

    $dendaList = $query->latest()->paginate(10)->withQueryString();

    return view('admin.dataDenda', compact('dendaList'));
}

public function konfirmasiDenda(Peminjaman $peminjaman)
{
    if ($peminjaman->status_denda !== 'Belum Dibayar') {
        return back()->with('error', 'Denda sudah dibayar atau tidak ada denda!');
    }

    $peminjaman->update([
        'status_denda' => 'Sudah Dibayar',
    ]);

    return back()->with('success', 'Denda berhasil dikonfirmasi sebagai sudah dibayar.');
}

}
