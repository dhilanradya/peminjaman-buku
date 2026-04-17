<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Login Umum
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'is_admin'])->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

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

    Route::get('/data-peminjaman', [App\Http\Controllers\Admin\PeminjamanController::class, 'index'])
         ->name('dataPeminjaman');

    Route::post('/peminjaman/{peminjaman}/terima', [App\Http\Controllers\Admin\PeminjamanController::class, 'terima'])
         ->name('peminjaman.terima');

    Route::post('/peminjaman/{peminjaman}/tolak', [App\Http\Controllers\Admin\PeminjamanController::class, 'tolak'])
         ->name('peminjaman.tolak');
});
// User Routes
// User Routes
// User Routes
Route::prefix('user')->name('user.')->middleware(['auth', 'is_user'])->group(function () {

    Route::get('/dashboard', function () {
        $books = \App\Models\Book::where('stok', '>', 0)
                    ->latest()
                    ->take(12)
                    ->get();
        return view('user.dashboard', compact('books'));
    })->name('dashboard');

    // Pinjam Buku
    Route::post('/pinjam', [App\Http\Controllers\User\PeminjamanUserController::class, 'store'])
         ->name('pinjam.store');

    // Riwayat Peminjaman
    Route::get('/riwayat', [App\Http\Controllers\User\PeminjamanUserController::class, 'riwayat'])
         ->name('riwayat');
});
