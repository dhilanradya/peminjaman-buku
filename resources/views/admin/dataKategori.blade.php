@extends('layouts.admin')

@section('title', 'Data Kategori - Admin')

@section('content')
<div class="max-w-7xl mx-auto">

    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white">Data Kategori</h1>
            <p class="text-gray-400 mt-1">Kelola kategori buku</p>
        </div>
        <a href="{{ route('admin.tambahKategori') }}"
           class="bg-blue-600 hover:bg-blue-700 px-6 py-3 rounded-2xl flex items-center gap-2">
            <i class="fas fa-plus"></i>
            <span>Tambah Kategori</span>
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-500/10 border border-green-500 text-green-400 px-5 py-4 rounded-2xl mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Table -->
    <div class="bg-gray-800 rounded-3xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[600px]">
                <thead>
                    <tr class="border-b border-gray-700">
                        <th class="py-5 px-6 text-gray-400">No</th>
                        <th class="py-5 px-6 text-gray-400">Kategori</th>
                        <th class="py-5 px-6 text-gray-400 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach($kategoris as $index => $kategori)
                    <tr class="hover:bg-gray-700/50">
                        <td class="py-5 px-6 text-gray-300">
                            {{ $index + 1 + ($kategoris->currentPage()-1)*$kategoris->perPage() }}
                        </td>
                        <td class="py-5 px-6 text-white font-medium">
                            {{ $kategori->nama }}
                        </td>
                        <td class="py-5 px-6 text-center">
                            <div class="flex justify-center gap-5">
                                <a href="{{ route('admin.editKategori', $kategori) }}"
                                   class="text-amber-400 hover:scale-110">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.hapusKategori', $kategori) }}" method="POST"
                                      onsubmit="return confirm('Yakin hapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-400 hover:scale-110">
                                        <i class="fas fa-trash"></i>
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

    <div class="mt-8 flex justify-center">
        {{ $kategoris->links('pagination::tailwind') }}
    </div>

</div>
@endsection
