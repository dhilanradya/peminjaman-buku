@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('content')
<div class="max-w-2xl mx-auto p-6">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white">Edit Kategori</h1>
        <p class="text-gray-400 mt-1">Perbarui kategori buku</p>
    </div>

    <div class="bg-gray-800 rounded-3xl p-8">

        @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500 text-red-400 px-5 py-4 rounded-2xl mb-6">
                <ul class="text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.updateKategori', $kategori) }}" method="POST">
            @csrf
            @method('PUT')

            <div>
                <label class="text-gray-400 text-sm">Nama Kategori</label>
                <input type="text" name="nama"
                    value="{{ old('nama', $kategori->nama) }}"
                    class="w-full mt-2 bg-gray-900 border border-gray-700 rounded-2xl px-5 py-4 text-white focus:border-blue-500"
                    placeholder="Contoh: Novel, Sejarah, Teknologi" required>
            </div>

            <div class="flex gap-4 mt-10">
                <button type="submit"
                        class="flex-1 bg-emerald-600 hover:bg-emerald-700 py-4 rounded-2xl">
                    <i class="fas fa-save mr-2"></i> Update
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
