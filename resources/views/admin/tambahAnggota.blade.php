@extends('layouts.admin')

@section('title', 'Tambah Anggota - Admin')

@section('content')
<div class="max-w-2xl mx-auto p-6">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white">Tambah Anggota Baru</h1>
        <p class="text-gray-400 mt-1">Buat akun anggota perpustakaan</p>
    </div>

    <div class="bg-gray-800 rounded-3xl p-8 shadow-xl">
        <form action="{{ route('admin.simpanAnggota') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Nama Lengkap</label>
                    <input type="text" name="nama"
                           class="w-full bg-gray-900 border border-gray-700 rounded-2xl px-5 py-4 text-white focus:outline-none focus:border-blue-500"
                           placeholder="Masukkan nama lengkap siswa" required>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">NIS</label>
                        <input type="text" name="nis"
                               class="w-full bg-gray-900 border border-gray-700 rounded-2xl px-5 py-4 text-white focus:outline-none focus:border-blue-500"
                               placeholder="Contoh: 12345678" required>
                    </div>
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Kelas</label>
                        <input type="text" name="kelas"
                               class="w-full bg-gray-900 border border-gray-700 rounded-2xl px-5 py-4 text-white focus:outline-none focus:border-blue-500"
                               placeholder="Contoh: XII IPA 3" required>
                    </div>
                </div>

                <div>
                    <label class="block text-gray-400 text-sm mb-2">No. HP</label>
                    <input type="text" name="no_hp"
                           class="w-full bg-gray-900 border border-gray-700 rounded-2xl px-5 py-4 text-white focus:outline-none focus:border-blue-500"
                           placeholder="Contoh: 081234567890" required>
                </div>

                <div>
                    <label class="block text-gray-400 text-sm mb-2">Email</label>
                    <input type="email" name="email"
                           class="w-full bg-gray-900 border border-gray-700 rounded-2xl px-5 py-4 text-white focus:outline-none focus:border-blue-500"
                           placeholder="contoh@email.com" required>
                </div>

                <div>
                    <label class="block text-gray-400 text-sm mb-2">Password</label>
                    <input type="password" name="password"
                           class="w-full bg-gray-900 border border-gray-700 rounded-2xl px-5 py-4 text-white focus:outline-none focus:border-blue-500"
                           placeholder="Minimal 6 karakter" required>
                </div>
            </div>

            <div class="flex gap-4 mt-10">
                <button type="submit"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 py-4 rounded-2xl font-medium transition">
                    <i class="fas fa-save mr-2"></i> Simpan Anggota
                </button>
                <a href="{{ route('admin.dataAnggota') }}"
                   class="flex-1 bg-gray-700 hover:bg-gray-600 py-4 rounded-2xl font-medium text-center transition">
                    Batal
                </a>
            </div>
        </form>
    </div>

</div>
@endsection
