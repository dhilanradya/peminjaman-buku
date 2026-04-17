@extends('layouts.admin')

@section('title', 'Tambah Buku - Admin')

@section('content')
<div class="min-h-screen bg-gray-900 p-6 ">

    <div class="max-w-2xl mx-auto">

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white">Tambah Buku Baru</h1>
            <p class="text-gray-400 mt-1">Masukkan data buku ke dalam sistem perpustakaan</p>
        </div>

        <div class="bg-gray-800 rounded-3xl p-8 shadow-xl">

            <form action="{{ route('admin.simpanBuku') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 gap-6">

                    <!-- Judul Buku -->
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Judul Buku</label>
                        <input type="text" name="judul"
                               class="w-full bg-gray-900 border border-gray-700 rounded-2xl px-5 py-4 focus:outline-none focus:border-blue-500 text-white"
                               placeholder="Masukkan judul buku" required>
                    </div>

                    <!-- Penulis -->
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Penulis</label>
                        <input type="text" name="penulis"
                               class="w-full bg-gray-900 border border-gray-700 rounded-2xl px-5 py-4 focus:outline-none focus:border-blue-500 text-white"
                               placeholder="Nama penulis" required>
                    </div>

                    <!-- Kategori & Penerbit -->
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-400 text-sm mb-2">Kategori</label>
                            <select name="kategori_id"
                                class="w-full bg-gray-900 border border-gray-700 rounded-2xl px-5 py-4 focus:outline-none focus:border-blue-500 text-white"
                                required>
                                <option value="">Pilih Kategori</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-400 text-sm mb-2">Penerbit</label>
                            <input type="text" name="penerbit"
                                   class="w-full bg-gray-900 border border-gray-700 rounded-2xl px-5 py-4 focus:outline-none focus:border-blue-500 text-white"
                                   placeholder="Nama penerbit" required>
                        </div>
                    </div>

                    <!-- Stok -->
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Stok Buku</label>
                        <input type="number" name="stok" min="0"
                               class="w-full bg-gray-900 border border-gray-700 rounded-2xl px-5 py-4 focus:outline-none focus:border-blue-500 text-white"
                               placeholder="Jumlah stok" required>
                    </div>

                    <!-- Foto Buku -->
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Foto Buku (Opsional)</label>
                        <input type="file" name="foto" accept="image/*"
                               class="w-full bg-gray-900 border border-gray-700 rounded-2xl px-5 py-4 focus:outline-none focus:border-blue-500 text-white">
                        <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG. Max 2MB</p>
                    </div>

                </div>

                <div class="flex gap-4 mt-10">
                    <button type="submit"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 py-4 rounded-2xl font-medium transition">
                        <i class="fas fa-save mr-2"></i> Simpan Buku
                    </button>
                    <a href="{{ route('admin.dataBuku') }}"
                       class="flex-1 bg-gray-700 hover:bg-gray-600 py-4 rounded-2xl font-medium text-center transition">
                        Batal
                    </a>
                </div>

            </form>
        </div>

    </div>
</div>
@endsection
