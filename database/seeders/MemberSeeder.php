<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MemberSeeder extends Seeder
{
    public function run()
    {
        // Hapus anggota lama (kecuali admin) agar tidak duplikat
        User::where('role', 'user')->delete();

        $members = [
            [
                'nama'     => 'Ahmad Fauzi',
                'nis'      => '12345678',
                'kelas'    => 'XII IPA 1',
                'no_hp'    => '081234567890',
                'email'    => 'ahmad.fauzi@email.com',
                'password' => 'password123',
            ],
            [
                'nama'     => 'Siti Nurhaliza',
                'nis'      => '12345679',
                'kelas'    => 'XII IPS 2',
                'no_hp'    => '085678901234',
                'email'    => 'siti.nurhaliza@email.com',
                'password' => 'password123',
            ],
            [
                'nama'     => 'Muhammad Rizki',
                'nis'      => '12345680',
                'kelas'    => 'XII IPA 3',
                'no_hp'    => '087654321098',
                'email'    => 'rizki.muhammad@email.com',
                'password' => 'password123',
            ],
            [
                'nama'     => 'Dewi Sartika',
                'nis'      => '12345681',
                'kelas'    => 'XII IPS 1',
                'no_hp'    => '089876543210',
                'email'    => 'dewi.sartika@email.com',
                'password' => 'password123',
            ],
            [
                'nama'     => 'Andi Pratama',
                'nis'      => '12345682',
                'kelas'    => 'XII IPA 2',
                'no_hp'    => '081112223344',
                'email'    => 'andi.pratama@email.com',
                'password' => 'password123',
            ],
        ];

        foreach ($members as $member) {
            User::create([
                'nama'     => $member['nama'],
                'nis'      => $member['nis'],
                'kelas'    => $member['kelas'],
                'no_hp'    => $member['no_hp'],
                'email'    => $member['email'],
                'password' => Hash::make($member['password']),
                'role'     => 'user',
            ]);
        }

        $this->command->info('✅ 5 data anggota dummy berhasil dibuat!');
    }
}
