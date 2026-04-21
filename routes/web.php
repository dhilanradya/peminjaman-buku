<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;

// Login Umum
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ====================== ADMIN ROUTES ======================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'is_admin'])->group(function () {

   Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

    // Buku
    Route::resource('data-buku', \App\Http\Controllers\Admin\BookController::class)
         ->names([
             'index'   => 'dataBuku',
             'create'  => 'tambahBuku',
             'store'   => 'simpanBuku',
             'edit'    => 'editBuku',
             'update'  => 'updateBuku',
             'destroy' => 'hapusBuku',
         ])
         ->parameters(['data-buku' => 'book']);

    // Kategori
    Route::resource('data-kategori', \App\Http\Controllers\Admin\KategoriController::class)
         ->names([
             'index'   => 'dataKategori',
             'create'  => 'tambahKategori',
             'store'   => 'simpanKategori',
             'edit'    => 'editKategori',
             'update'  => 'updateKategori',
             'destroy' => 'hapusKategori',
         ])
         ->parameters(['data-kategori' => 'kategori']);

    // Anggota
    Route::resource('data-anggota', \App\Http\Controllers\Admin\MemberController::class)
         ->names([
             'index'   => 'dataAnggota',
             'create'  => 'tambahAnggota',
             'store'   => 'simpanAnggota',
             'edit'    => 'editAnggota',
             'update'  => 'updateAnggota',
             'destroy' => 'hapusAnggota',
         ])
         ->parameters(['data-anggota' => 'member']);

    // Peminjaman
    Route::get('/data-peminjaman', [App\Http\Controllers\Admin\PeminjamanController::class, 'index'])
         ->name('dataPeminjaman');

    Route::post('/peminjaman/{peminjaman}/terima', [App\Http\Controllers\Admin\PeminjamanController::class, 'terima'])
         ->name('peminjaman.terima');

    Route::post('/peminjaman/{peminjaman}/tolak', [App\Http\Controllers\Admin\PeminjamanController::class, 'tolak'])
         ->name('peminjaman.tolak');

    // Laporan Pengembalian
    Route::get('/laporan', [App\Http\Controllers\Admin\LaporanController::class, 'index'])
         ->name('laporan');
         // Di dalam group admin
    Route::get('/laporan/export-excel', [App\Http\Controllers\Admin\LaporanController::class, 'exportExcel'])
        ->name('laporan.export.excel');

    Route::get('/laporan/export-pdf', [App\Http\Controllers\Admin\LaporanController::class, 'exportPdf'])
        ->name('laporan.export.pdf');
});

// ====================== USER ROUTES ======================
Route::prefix('user')->name('user.')->middleware(['auth', 'is_user'])->group(function () {

    Route::get('/dashboard', function (Illuminate\Http\Request $request) {

    $query = \App\Models\Book::query();

    // Search
    if ($request->search) {
        $search = $request->search;
        $query->where('judul', 'like', "%$search%");
    }

    // Filter kategori
    if ($request->kategori_id) {
        $query->where('kategori_id', $request->kategori_id);
    }

    $books = $query->latest()->take(10)->get();
    $kategoris = \App\Models\Kategori::all();

    return view('user.dashboard', compact('books', 'kategoris'));
})->name('dashboard');

    // Pinjam Buku
    Route::post('/pinjam', [App\Http\Controllers\User\PeminjamanUserController::class, 'store'])
         ->name('pinjam.store');

    // Riwayat Peminjaman
    Route::get('/riwayat', [App\Http\Controllers\User\PeminjamanUserController::class, 'riwayat'])
         ->name('riwayat');

    // Pengembalian Buku
    Route::post('/kembalikan/{peminjaman}', [App\Http\Controllers\User\PeminjamanUserController::class, 'kembalikan'])
         ->name('kembalikan');

    Route::get('/buku', [App\Http\Controllers\User\BukuController::class, 'index'])
    ->name('buku');
});
