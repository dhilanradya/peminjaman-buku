<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\User;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBuku = Book::count();
        $totalStok = Book::sum('stok');
        $totalPeminjaman = Peminjaman::where('status', '!=', 'Dikembalikan')->count();
        $totalUser = User::where('role', 'user')->count();

        // Tambahkan total denda yang belum dibayar
        $totalDenda = Peminjaman::where('status_denda', 'Belum Dibayar')->sum('denda');

        $aktivitas = Peminjaman::with(['user', 'book'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalBuku',
            'totalStok',
            'totalPeminjaman',
            'totalUser',
            'totalDenda',
            'aktivitas'
        ));
    }
}
