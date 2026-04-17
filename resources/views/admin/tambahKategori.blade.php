@extends('layouts.admin')

@section('title', 'Tambah Kategori')

@section('content')
<div class="max-w-2xl mx-auto p-6">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white">Tambah Kategori</h1>
        <p class="text-gray-400 mt-1">Tambahkan kategori buku baru</p>
    </div>

    <div class="bg-gray-800 rounded-3xl p-8">
        <form action="{{ route('admin.simpanKategori') }}" method="POST">
            @csrf

            <div>
                <label class="text-gray-400 text-sm">Nama Kategori</label>
                <input type="text" name="nama"
                    class="w-full mt-2 bg-gray-900 border border-gray-700 rounded-2xl px-5 py-4 text-white focus:border-blue-500"
                    placeholder="Contoh: Novel, Sejarah, Teknologi" required>
            </div>

            <div class="flex gap-4 mt-10">
                <button type="submit"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 py-4 rounded-2xl">
                    Simpan
                </button>

                <a href="{{ route('admin.dataKategori') }}"
                   class="flex-1 bg-gray-700 hover:bg-gray-600 py-4 rounded-2xl text-center">
                    Batal
                </a>
            </div>

        </form>
    </div>

</div>
@endsection
