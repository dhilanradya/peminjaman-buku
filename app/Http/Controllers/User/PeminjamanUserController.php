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

    $books    = $query->paginate(10);
    $kategoris = Kategori::all();

    $punyaDendaBelumBayar = Peminjaman::where('user_id', Auth::id())
        ->where('status_denda', 'Belum Dibayar')
        ->exists();

    $punyaPinjamanAktif = $punyaDendaBelumBayar || Peminjaman::where('user_id', Auth::id())
        ->whereIn('status', ['Menunggu', 'Diterima', 'Menunggu Pengembalian'])
        ->exists();

    $bukuDipinjam = Peminjaman::with('book')
        ->where('user_id', Auth::id())
        ->whereIn('status', ['Diterima', 'Menunggu Pengembalian'])
        ->get();

    return view('user.dashboard', compact(
        'books',
        'kategoris',
        'bukuDipinjam',
        'punyaPinjamanAktif',
        'punyaDendaBelumBayar'
    ));
}

    // Store peminjaman baru
   public function store(Request $request)
{
    $request->validate([
        'book_id' => 'required|exists:books,id',
        'hari'    => 'required|integer|min:1|max:20',
    ]);

    $book = Book::findOrFail($request->book_id);

    // ❌ CEK DENDA BELUM DIBAYAR
    $punyaDenda = Peminjaman::where('user_id', Auth::id())
        ->where('status_denda', 'Belum Dibayar')
        ->exists();

    if ($punyaDenda) {
        return redirect()->route('user.dashboard')
        ->with('warning', 'Anda masih memiliki denda yang belum dibayar! Silakan lunasi terlebih dahulu.');
    }

    // ❌ CEK PEMINJAMAN AKTIF
    $aktif = Peminjaman::where('user_id', Auth::id())
        ->whereIn('status', ['Menunggu', 'Diterima', 'Menunggu Pengembalian'])
        ->exists();

    if ($aktif) {
        return redirect()->route('user.dashboard')
        ->with('warning', 'Anda masih memiliki peminjaman aktif!');
    }

    if ($book->stok < 1) {
        return redirect()->route('user.dashboard')
        ->with('error', 'Stok buku tidak tersedia!');
    }

    Peminjaman::create([
        'user_id'     => Auth::id(),
        'book_id'     => $request->book_id,
        'jumlah'      => 1,
        'tgl_pinjam'  => now()->toDateString(),
        'tgl_kembali' => now()->addDays((int) $request->hari)->toDateString(),
        'status'      => 'Menunggu',
    ]);

    return redirect()->route('user.dashboard')
        ->with('success', 'Pengajuan peminjaman berhasil dikirim!');
}


public function kembalikan(Peminjaman $peminjaman)
{
    if ($peminjaman->user_id !== Auth::id()) {
        abort(403);
    }

    if ($peminjaman->status !== 'Diterima') {
        return back()->with('error', 'Peminjaman tidak dalam status aktif!');
    }

    // Hanya ubah status, belum isi tanggal & denda
    $peminjaman->update([
        'status' => 'Menunggu Pengembalian',
    ]);

    return back()->with('success', 'Pengajuan pengembalian berhasil dikirim! Menunggu konfirmasi admin.');
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
