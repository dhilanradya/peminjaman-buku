<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class BookSeeder extends Seeder
{
    public function run()
    {
        // Hapus folder books lama dan buat baru
        Storage::disk('public')->deleteDirectory('books');
        Storage::disk('public')->makeDirectory('books');

        $dummyBooks = [
            [
                'judul'     => 'Laskar Pelangi',
                'penulis'   => 'Andrea Hirata',
                'kategori'  => 'Fiksi',
                'penerbit'  => 'Bentang Pustaka',
                'stok'      => 23,
                'image_url' => 'https://picsum.photos/id/1015/800/1200', // Buku novel
            ],
            [
                'judul'     => 'Negeri 5 Menara',
                'penulis'   => 'Ahmad Fuadi',
                'kategori'  => 'Fiksi',
                'penerbit'  => 'Gramedia Pustaka Utama',
                'stok'      => 15,
                'image_url' => 'https://picsum.photos/id/201/800/1200',
            ],
            [
                'judul'     => 'Atomic Habits',
                'penulis'   => 'James Clear',
                'kategori'  => 'Non-Fiksi',
                'penerbit'  => 'Gramedia Pustaka Utama',
                'stok'      => 18,
                'image_url' => 'https://picsum.photos/id/367/800/1200',
            ],
            [
                'judul'     => 'The Psychology of Money',
                'penulis'   => 'Morgan Housel',
                'kategori'  => 'Non-Fiksi',
                'penerbit'  => 'Gramedia',
                'stok'      => 9,
                'image_url' => 'https://picsum.photos/id/870/800/1200',
            ],
            [
                'judul'     => 'Harry Potter and The Philosopher\'s Stone',
                'penulis'   => 'J.K. Rowling',
                'kategori'  => 'Fiksi',
                'penerbit'  => 'Bloomsbury',
                'stok'      => 7,
                'image_url' => 'https://picsum.photos/id/1016/800/1200',
            ],
            [
                'judul'     => 'Sapiens: Riwayat Singkat Umat Manusia',
                'penulis'   => 'Yuval Noah Harari',
                'kategori'  => 'Non-Fiksi',
                'penerbit'  => 'Gramedia Pustaka Utama',
                'stok'      => 14,
                'image_url' => 'https://picsum.photos/id/106/800/1200',
            ],
            [
                'judul'     => 'Bumi',
                'penulis'   => 'Tere Liye',
                'kategori'  => 'Fiksi',
                'penerbit'  => 'Gramedia Pustaka Utama',
                'stok'      => 0,
                'image_url' => 'https://picsum.photos/id/133/800/1200',
            ],
            [
                'judul'     => 'Matematika Dasar SMA',
                'penulis'   => 'Tim Erlangga',
                'kategori'  => 'Pendidikan',
                'penerbit'  => 'Erlangga',
                'stok'      => 45,
                'image_url' => 'https://picsum.photos/id/201/800/1200',
            ],
        ];

        foreach ($dummyBooks as $data) {
            $imageUrl = $data['image_url'];
            unset($data['image_url']); // hapus key yang tidak perlu

            $book = Book::create($data);

            // Download gambar dummy
            try {
                $response = Http::timeout(10)->get($imageUrl);

                if ($response->successful()) {
                    $filename = $book->id . '_' . time() . '.jpg';
                    Storage::disk('public')->put('books/' . $filename, $response->body());
                    $book->update(['foto' => $filename]);
                }
            } catch (\Exception $e) {
                // Jika gagal download, tetap buat bukunya tanpa foto
                $this->command->warn("Gagal download foto untuk: " . $book->judul);
            }
        }

        $this->command->info('✅ ' . count($dummyBooks) . ' buku dummy beserta gambarnya berhasil dibuat!');
    }
}
