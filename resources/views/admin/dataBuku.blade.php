@extends('layouts.admin')

@section('title', 'Data Buku - Admin')

@section('content')
<div class="max-w-7xl mx-auto">

    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white">Data Buku</h1>
            <p class="text-gray-400 mt-1">Kelola koleksi buku perpustakaan</p>
        </div>
        <a href="{{ route('admin.tambahBuku') }}"
           class="bg-blue-600 hover:bg-blue-700 px-6 py-3 rounded-2xl flex items-center gap-2 transition-all">
            <i class="fas fa-plus"></i>
            <span>Tambah Buku Baru</span>
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-500/10 border border-green-500 text-green-400 px-5 py-4 rounded-2xl mb-6 flex items-center gap-3">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Search & Filter -->
    <div class="bg-gray-800 rounded-3xl p-5 mb-6">
        <form method="GET" class="flex gap-4">
            <div class="flex-1">
                <input type="text" name="search"
                       class="w-full bg-gray-900 border border-gray-700 rounded-2xl px-5 py-3.5 focus:outline-none focus:border-blue-500 text-white placeholder-gray-500"
                       placeholder="Cari judul buku, penulis, atau penerbit..."
                       value="{{ request('search') }}">
            </div>

            <!-- ✅ FILTER KATEGORI DINAMIS -->
            <div class="w-72">
                <select name="kategori_id"
                        class="w-full bg-gray-900 border border-gray-700 rounded-2xl px-5 py-3.5 focus:outline-none focus:border-blue-500 text-white">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}"
                            {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit"
                    class="bg-gray-700 hover:bg-gray-600 px-8 rounded-2xl transition text-white">
                <i class="fas fa-filter"></i>
            </button>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-gray-800 rounded-3xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1100px]">
                <thead>
                    <tr class="border-b border-gray-700">
                        <th class="text-left py-5 px-6 text-gray-400 font-medium w-12">No</th>
                        <th class="text-left py-5 px-6 text-gray-400 font-medium">Foto</th>
                        <th class="text-left py-5 px-6 text-gray-400 font-medium">Judul Buku</th>
                        <th class="text-left py-5 px-6 text-gray-400 font-medium">Penulis</th>
                        <th class="text-left py-5 px-6 text-gray-400 font-medium">Kategori</th>
                        <th class="text-left py-5 px-6 text-gray-400 font-medium">Penerbit</th>
                        <th class="text-center py-5 px-6 text-gray-400 font-medium w-20">Stok</th>
                        <th class="text-center py-5 px-6 text-gray-400 font-medium w-36">Status</th>
                        <th class="text-center py-5 px-6 text-gray-400 font-medium w-32">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-700">
                    @foreach($books as $index => $book)
                    <tr class="hover:bg-gray-700/50 transition">
                        <td class="py-5 px-6 text-gray-300">
                            {{ $index + 1 + ($books->currentPage()-1)*$books->perPage() }}
                        </td>

                        <!-- Foto -->
                        <td class="py-5 px-6">
                            @if($book->foto)
                                <img src="{{ asset('storage/books/' . $book->foto) }}"
                                     class="w-16 h-20 object-cover rounded-xl">
                            @else
                                <div class="w-12 h-16 bg-gray-700 rounded-xl flex items-center justify-center text-gray-500">
                                    <i class="fas fa-book"></i>
                                </div>
                            @endif
                        </td>

                        <!-- Data -->
                        <td class="py-5 px-6 font-medium text-white">{{ $book->judul }}</td>
                        <td class="py-5 px-6 text-gray-300">{{ $book->penulis }}</td>

                        <!-- ✅ KATEGORI (RELASI) -->
                        <td class="py-5 px-6">
                            @if($book->kategori)
                                <span class="px-4 py-1.5 text-xs font-medium rounded-2xl bg-blue-500/20 text-blue-400">
                                    {{ $book->kategori->nama }}
                                </span>
                            @else
                                <span class="text-gray-500 text-sm">-</span>
                            @endif
                        </td>

                        <td class="py-5 px-6 text-gray-300">{{ $book->penerbit }}</td>

                        <!-- Stok -->
                        <td class="py-5 px-6 text-center font-bold text-lg text-gray-300">
                            {{ $book->stok }}
                        </td>

                        <!-- Status -->
                        <td class="py-5 px-6 text-center">
                            @if($book->stok > 0)
                                <span class="inline-block px-5 py-1.5 bg-emerald-500/20 text-emerald-400 text-sm font-medium rounded-2xl">
                                    Tersedia
                                </span>
                            @else
                                <span class="inline-block px-5 py-1.5 bg-red-500/20 text-red-400 text-sm font-medium rounded-2xl">
                                    Tidak Tersedia
                                </span>
                            @endif
                        </td>

                        <!-- Aksi -->
                        <td class="py-5 px-6 text-center">
                            <div class="flex items-center justify-center gap-5">
                                <a href="{{ route('admin.editBuku', $book) }}"
                                   class="text-amber-400 hover:text-amber-300 hover:scale-110 transition">
                                    <i class="fas fa-edit text-xl"></i>
                                </a>

                                <form action="{{ route('admin.hapusBuku', $book) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-400 hover:text-red-300 hover:scale-110 transition">
                                        <i class="fas fa-trash text-xl"></i>
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-8 flex justify-center">
        @if($books->hasPages())
            {{ $books->links('pagination::tailwind') }}
        @endif
    </div>

</div>
@endsection
