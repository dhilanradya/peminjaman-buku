<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'], // kondisi cek
            [
                'nama'     => 'Administrator',
                'password' => Hash::make('123123'),
                'role'     => 'admin',
            ]
        );

        if ($admin->wasRecentlyCreated) {
            $this->command->info('✅ Akun admin berhasil dibuat (admin@gmail.com)');
        } else {
            $this->command->info('⚠️ Akun admin sudah ada (admin@gmail.com)');
        }
    }
}
