<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanUserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'jumlah'  => 'required|integer|min:1|max:5',
            'hari'    => 'required|integer|min:1|max:20',
        ]);

        $book = Book::findOrFail($request->book_id);

        // Validasi stok
        if ($book->stok < $request->jumlah) {
            return back()->with('error', 'Stok buku tidak mencukupi! Maksimal tersedia: ' . $book->stok);
        }

        // Perbaikan utama: Cast ke integer
        $jumlah = (int) $request->jumlah;
        $hari   = (int) $request->hari;

        Peminjaman::create([
            'user_id'     => Auth::id(),
            'book_id'     => $request->book_id,
            'tgl_pinjam'  => now()->toDateString(),
            'tgl_kembali' => now()->addDays($hari)->toDateString(),  // sekarang sudah integer
            'status'      => 'Menunggu',
        ]);

        // Kurangi stok sementara (opsional, bisa diatur saat admin terima)
        // $book->decrement('stok', $jumlah);

        return redirect()->route('user.dashboard')
                         ->with('success', 'Permintaan peminjaman berhasil diajukan. Menunggu persetujuan admin.');
    }

    public function riwayat()
    {
        $riwayat = Peminjaman::with('book')
                    ->where('user_id', Auth::id())
                    ->latest()
                    ->paginate(10);

        return view('user.riwayat', compact('riwayat'));
    }
}
