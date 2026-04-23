<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Book;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with(['user', 'book'])
                        ->latest()
                        ->paginate(10);

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

}
