<?php

namespace Database\Seeders;

use App\Models\Peminjaman;
use App\Models\User;
use App\Models\Book;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PeminjamanSeeder extends Seeder
{
    public function run()
    {
        // Hapus data peminjaman lama
        Peminjaman::truncate();

        // Ambil data user dan buku yang sudah ada
        $users = User::where('role', 'user')->get();
        $books = Book::all();

        if ($users->isEmpty() || $books->isEmpty()) {
            $this->command->error('Pastikan Anda sudah menjalankan MemberSeeder dan BookSeeder terlebih dahulu!');
            return;
        }

        $peminjamanData = [
            [
                'user_id'     => $users[0]->id,           // Ahmad Fauzi
                'book_id'     => $books[0]->id,           // Laskar Pelangi
                'tgl_pinjam'  => Carbon::now()->subDays(5),
                'tgl_kembali' => Carbon::now()->addDays(10),
                'status'      => 'Menunggu',
            ],
            [
                'user_id'     => $users[1]->id,           // Siti Nurhaliza
                'book_id'     => $books[1]->id,           // Negeri 5 Menara
                'tgl_pinjam'  => Carbon::now()->subDays(3),
                'tgl_kembali' => Carbon::now()->addDays(7),
                'status'      => 'Diterima',
            ],
            [
                'user_id'     => $users[2]->id,           // Muhammad Rizki
                'book_id'     => $books[3]->id,           // Atomic Habits
                'tgl_pinjam'  => Carbon::now()->subDays(1),
                'tgl_kembali' => null,
                'status'      => 'Menunggu',
            ],
        ];

        foreach ($peminjamanData as $data) {
            Peminjaman::create($data);
        }

        $this->command->info('✅ 3 data peminjaman dummy berhasil dibuat!');
    }
}
