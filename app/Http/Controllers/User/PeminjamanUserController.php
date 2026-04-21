<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Book;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PeminjamanUserController extends Controller
{
    // Dashboard: tampilkan buku tersedia + buku sedang dipinjam user
    public function dashboard(Request $request)
    {
        $query = Book::query();

        if ($request->search) {
            $query->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('penulis', 'like', '%' . $request->search . '%');
        }

        if ($request->kategori_id) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $books = $query->paginate(10);
        $kategoris = Kategori::all();

        // Ambil peminjaman user yang sedang aktif (status Diterima)
        $bukuDipinjam = Peminjaman::with('book')
            ->where('user_id', Auth::id())
            ->where('status', 'Diterima')
            ->get();

        return view('user.dashboard', compact('books', 'kategoris', 'bukuDipinjam'));
    }

    // Store peminjaman baru
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'jumlah'  => 'required|integer|min:1|max:5',
            'hari'    => 'required|integer|min:1|max:20',
        ]);

        $book = Book::findOrFail($request->book_id);

        if ($book->stok < $request->jumlah) {
            return back()->with('error', 'Stok buku tidak mencukupi!');
        }

        Peminjaman::create([
            'user_id'     => Auth::id(),
            'book_id'     => $request->book_id,
            'jumlah'      => (int) $request->jumlah,
            'tgl_pinjam'  => now()->toDateString(),
            'tgl_kembali' => now()->addDays((int) $request->hari)->toDateString(), // tambah (int)
            'status'      => 'Menunggu',
        ]);

        return back()->with('success', 'Pengajuan peminjaman berhasil dikirim!');
    }

    // Kembalikan buku (dipanggil dari modal di dashboard)
    public function kembalikan(Peminjaman $peminjaman)
    {
        // Pastikan peminjaman milik user yang login
        if ($peminjaman->user_id !== Auth::id()) {
            abort(403);
        }

        if ($peminjaman->status !== 'Diterima') {
            return back()->with('error', 'Peminjaman tidak dalam status aktif!');
        }

        $tglKembaliActual = now()->toDateString();
        $tglBatas = Carbon::parse($peminjaman->tgl_kembali);
        $tglActual = Carbon::parse($tglKembaliActual);

        $denda = 0;
        if ($tglActual->gt($tglBatas)) {
            $telat = $tglBatas->diffInDays($tglActual);
            $denda = $telat * 1000; // Rp 1.000 per hari keterlambatan
        }

        // Kembalikan stok buku
        $peminjaman->book->increment('stok', $peminjaman->jumlah);

        $peminjaman->update([
            'status'            => 'Dikembalikan',
            'tgl_kembali_actual'=> $tglKembaliActual,
            'denda'             => $denda,
        ]);

        return back()->with('success', 'Buku berhasil dikembalikan!' . ($denda > 0 ? ' Denda: Rp ' . number_format($denda, 0, ',', '.') : ''));
    }

    // Riwayat peminjaman user
    public function riwayat()
    {
        $riwayat = Peminjaman::with('book')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('user.riwayat', compact('riwayat'));
    }
}
