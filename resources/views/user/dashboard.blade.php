@extends('layouts.user')

@section('title', 'Dashboard - User')

@section('content')
<div class="max-w-7xl mx-auto px-6">

    <!-- Welcome -->
    <div class="mb-10">
        <h1 class="text-4xl font-bold text-white">Selamat Datang, {{ Auth::user()->nama ?? Auth::user()->email }}</h1>
        <p class="text-gray-400 mt-2 text-lg">Silahkan pilih buku yang ingin Anda pinjam</p>
    </div>

    <!-- Book Display / Grid -->
    <div class="mb-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-white">Buku Tersedia</h2>
            <a href="#" class="text-blue-400 hover:text-blue-500 flex items-center gap-2">
                Lihat Semua Buku <i class="fas fa-arrow-right"></i>
            </a>
        </div>

       <!-- Book Grid -->
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
    @foreach($books as $book)
    <div class="bg-gray-800 rounded-3xl overflow-hidden border border-gray-700 hover:border-blue-500 transition group">
        <div class="h-64 bg-gray-700 relative">
            @if($book->foto)
                <img src="{{ asset('storage/books/' . $book->foto) }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition">
            @else
                <div class="w-full h-full flex items-center justify-center text-6xl text-gray-600">
                    <i class="fas fa-book"></i>
                </div>
            @endif

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

<!-- Include Modal -->
@include('components.modal-pinjam')
    </div>

</div>
@endsection
