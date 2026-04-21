@extends('layouts.user')

@section('title', 'Semua Buku')

@section('content')
<div class="max-w-7xl mx-auto px-6">

    <h1 class="text-3xl font-bold text-white mb-6">Semua Buku</h1>

    <!-- SEARCH + FILTER -->
    <form method="GET" class="mb-6">

        <div class="flex gap-3 mb-4">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari buku..."
                class="w-full px-4 py-2 rounded-xl bg-gray-800 border border-gray-700 text-white">

            <button class="bg-blue-600 px-5 rounded-xl">
                Cari
            </button>
        </div>

        <div class="flex flex-wrap gap-2">
            <a href="{{ route('user.buku') }}"
                class="px-4 py-2 rounded-xl text-sm
                {{ !request('kategori_id') ? 'bg-blue-600' : 'bg-gray-700' }}">
                Semua
            </a>

            @foreach($kategoris as $kategori)
                <a href="{{ route('user.buku', ['kategori_id' => $kategori->id]) }}"
                    class="px-4 py-2 rounded-xl text-sm
                    {{ request('kategori_id') == $kategori->id ? 'bg-blue-600' : 'bg-gray-700' }}">
                    {{ $kategori->nama }}
                </a>
            @endforeach
        </div>

    </form>

   <!-- GRID -->
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
    @foreach($books as $book)
    <div class="bg-gray-800 rounded-3xl overflow-hidden border border-gray-700 hover:border-blue-500 transition group">

        <!-- IMAGE -->
        <div class="h-64 bg-gray-700 relative">
            @if($book->foto)
                <img src="{{ asset('storage/books/' . $book->foto) }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition">
            @else
                <div class="w-full h-full flex items-center justify-center text-6xl text-gray-600">
                    <i class="fas fa-book"></i>
                </div>
            @endif

            <!-- STATUS -->
            @if($book->stok > 0)
                <div class="absolute top-3 right-3 bg-emerald-500 text-white text-xs px-3 py-1 rounded-2xl font-medium">
                    Tersedia
                </div>
            @else
                <div class="absolute top-3 right-3 bg-red-500 text-white text-xs px-3 py-1 rounded-2xl font-medium">
                    Habis
                </div>
            @endif
        </div>

        <!-- CONTENT -->
        <div class="p-5">
            <h3 class="font-semibold text-white line-clamp-2 h-12">{{ $book->judul }}</h3>
            <p class="text-gray-400 text-sm mt-1">{{ $book->penulis }}</p>

            <div class="flex justify-between items-center mt-4">
                <div>
                    <span class="text-xs text-gray-500">Stok</span>
                    <p class="font-bold text-lg {{ $book->stok > 0 ? 'text-emerald-400' : 'text-red-400' }}">
                        {{ $book->stok }}
                    </p>
                </div>

                @if($book->stok > 0)
                    <button onclick='openPinjamModal({{ json_encode($book) }})'
                            class="bg-blue-600 hover:bg-blue-700 px-5 py-2.5 rounded-2xl text-sm font-medium transition">
                        Pinjam
                    </button>
                @else
                    <button disabled class="bg-gray-700 px-5 py-2.5 rounded-2xl text-sm font-medium cursor-not-allowed">
                        Habis
                    </button>
                @endif
            </div>
        </div>

    </div>
    @endforeach
</div>

<!-- MODAL PINJAM -->
@include('components.modal-pinjam')

    <!-- PAGINATION -->
    <div class="mt-8">
        {{ $books->links() }}
    </div>

</div>
@endsection
