<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'Fiksi',
            'Non-Fiksi',
            'Pendidikan',
            'Teknologi',
            'Sejarah'
        ];

        foreach ($data as $nama) {
            Kategori::create(['nama' => $nama]);
        }
    }
}
