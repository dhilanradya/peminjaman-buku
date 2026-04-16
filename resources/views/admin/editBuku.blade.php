@extends('layouts.admin')

@section('title', 'Edit Buku - Admin')

@section('content')
<div class="min-h-screen bg-gray-900 p-6 ">

    <div class="max-w-2xl mx-auto">

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white">Edit Buku</h1>
            <p class="text-gray-400 mt-1">Perbarui data buku "{{ $book->judul }}"</p>
        </div>

        <div class="bg-gray-800 rounded-3xl p-8 shadow-xl">

            <form action="{{ route('admin.updateBuku', $book) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6">

                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Judul Buku</label>
                        <input type="text" name="judul" value="{{ old('judul', $book->judul) }}"
                               class="w-full bg-gray-900 border border-gray-700 rounded-2xl px-5 py-4 focus:outline-none focus:border-blue-500 text-white"
                               required>
                    </div>

                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Penulis</label>
                        <input type="text" name="penulis" value="{{ old('penulis', $book->penulis) }}"
                               class="w-full bg-gray-900 border border-gray-700 rounded-2xl px-5 py-4 focus:outline-none focus:border-blue-500 text-white"
                               required>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-400 text-sm mb-2">Kategori</label>
                            <select name="kategori"
                                    class="w-full bg-gray-900 border border-gray-700 rounded-2xl px-5 py-4 focus:outline-none focus:border-blue-500 text-white"
                                    required>
                                <option value="Fiksi" {{ old('kategori', $book->kategori) == 'Fiksi' ? 'selected' : '' }}>Fiksi</option>
                                <option value="Non-Fiksi" {{ old('kategori', $book->kategori) == 'Non-Fiksi' ? 'selected' : '' }}>Non-Fiksi</option>
                                <option value="Pendidikan" {{ old('kategori', $book->kategori) == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-400 text-sm mb-2">Penerbit</label>
                            <input type="text" name="penerbit" value="{{ old('penerbit', $book->penerbit) }}"
                                   class="w-full bg-gray-900 border border-gray-700 rounded-2xl px-5 py-4 focus:outline-none focus:border-blue-500 text-white"
                                   required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Stok Buku</label>
                        <input type="number" name="stok" value="{{ old('stok', $book->stok) }}" min="0"
                               class="w-full bg-gray-900 border border-gray-700 rounded-2xl px-5 py-4 focus:outline-none focus:border-blue-500 text-white"
                               required>
                    </div>

                    <!-- Foto Saat Ini -->
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Foto Buku Saat Ini</label>
                        @if($book->foto)
                            <img src="{{ asset('storage/books/' . $book->foto) }}"
                                 class="w-32 h-40 object-cover rounded-2xl mb-4 border border-gray-700">
                        @else
                            <div class="w-32 h-40 bg-gray-700 rounded-2xl flex items-center justify-center text-gray-500 mb-4">
                                <i class="fas fa-book text-4xl"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Upload Foto Baru -->
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Ganti Foto Buku (Opsional)</label>
                        <input type="file" name="foto" accept="image/*"
                               class="w-full bg-gray-900 border border-gray-700 rounded-2xl px-5 py-4 focus:outline-none focus:border-blue-500 text-white">
                    </div>

                </div>

                <div class="flex gap-4 mt-10">
                    <button type="submit"
                            class="flex-1 bg-emerald-600 hover:bg-emerald-700 py-4 rounded-2xl font-medium transition">
                        <i class="fas fa-save mr-2"></i> Simpan Perubahan
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
