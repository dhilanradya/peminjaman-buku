@extends('layouts.user')

@section('title', 'Dashboard - User')

@section('content')
<div class="max-w-7xl mx-auto px-6">

    <!-- Welcome -->
    <div class="mb-10">
        <h1 class="text-4xl font-bold text-white">Selamat Datang, {{ Auth::user()->nama ?? Auth::user()->email }}</h1>
        <p class="text-gray-400 mt-2 text-lg">Silahkan pilih buku yang ingin Anda pinjam</p>
    </div>

    <!-- BUKU SEDANG DIPINJAM -->
    @if($bukuDipinjam->count() > 0)
    <div class="mb-10">
        <h2 class="text-2xl font-semibold text-white mb-6">Buku Sedang Dipinjam</h2>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
            @foreach($bukuDipinjam as $p)
            @php
                $today = \Carbon\Carbon::today();
                $batas = \Carbon\Carbon::parse($p->tgl_kembali);
                $sisaHari = $today->diffInDays($batas, false); // negatif jika terlambat
            @endphp
            <div class="bg-gray-800 rounded-3xl overflow-hidden border border-blue-500/40 hover:border-blue-500 transition group">
                <div class="h-64 bg-gray-700 relative">
                    @if($p->book->foto)
                        <img src="{{ asset('storage/books/' . $p->book->foto) }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-6xl text-gray-600">
                            <i class="fas fa-book"></i>
                        </div>
                    @endif

                    @if($sisaHari < 0)
                        <div class="absolute top-3 right-3 bg-red-500 text-white text-xs px-3 py-1 rounded-2xl font-medium">
                            Terlambat {{ abs((int)$sisaHari) }}h
                        </div>
                    @elseif($sisaHari <= 3)
                        <div class="absolute top-3 right-3 bg-yellow-500 text-white text-xs px-3 py-1 rounded-2xl font-medium">
                            Sisa {{ (int)$sisaHari }} hari
                        </div>
                    @else
                        <div class="absolute top-3 right-3 bg-blue-500 text-white text-xs px-3 py-1 rounded-2xl font-medium">
                            Sisa {{ (int)$sisaHari }} hari
                        </div>
                    @endif
                </div>

                <div class="p-5">
                    <h3 class="font-semibold text-white line-clamp-2 h-12">{{ $p->book->judul }}</h3>
                    <p class="text-gray-400 text-sm mt-1">{{ $p->book->penulis }}</p>

                    <div class="flex justify-between items-center mt-4">
                        <div>
                            <span class="text-xs text-gray-500">Dipinjam</span>
                            <p class="font-bold text-lg text-blue-400">{{ $p->jumlah }} eks</p>
                        </div>

                        <button onclick='openKembalikanModal({{ json_encode([
                            "id" => $p->id,
                            "judul" => $p->book->judul,
                            "penulis" => $p->book->penulis,
                            "foto" => $p->book->foto,
                            "jumlah" => $p->jumlah,
                            "tgl_pinjam" => \Carbon\Carbon::parse($p->tgl_pinjam)->format("d M Y"),
                            "tgl_kembali" => \Carbon\Carbon::parse($p->tgl_kembali)->format("d M Y"),
                            "sisa_hari" => (int)$sisaHari,
                        ]) }})'
                                class="bg-emerald-600 hover:bg-emerald-700 px-4 py-2.5 rounded-2xl text-sm font-medium transition">
                            Kembalikan
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- SEARCH + FILTER -->
    <form method="GET" class="mb-6">
        <div class="flex gap-3 mb-4">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari buku..."
                class="w-full px-4 py-2 rounded-xl bg-gray-800 border border-gray-700 text-white focus:ring-2 focus:ring-blue-500">
            <button class="bg-blue-600 px-5 rounded-xl">Cari</button>
        </div>

        <div class="flex flex-wrap gap-2">
            <a href="{{ route('user.dashboard') }}"
                class="px-4 py-2 rounded-xl text-sm {{ !request('kategori_id') ? 'bg-blue-600' : 'bg-gray-700' }}">
                Semua
            </a>
            @foreach($kategoris as $kategori)
                <a href="{{ route('user.dashboard', ['kategori_id' => $kategori->id]) }}"
                    class="px-4 py-2 rounded-xl text-sm {{ request('kategori_id') == $kategori->id ? 'bg-blue-600' : 'bg-gray-700' }}">
                    {{ $kategori->nama }}
                </a>
            @endforeach
        </div>
    </form>

    <!-- BUKU TERSEDIA -->
    <div class="mb-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-white">Buku Tersedia</h2>
            <a href="{{ route('user.buku') }}" class="text-blue-400 hover:text-blue-500 flex items-center gap-2">
                Lihat Semua Buku <i class="fas fa-arrow-right"></i>
            </a>
        </div>

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
    </div>

</div>

@include('components.modal-pinjam')
@include('components.modal-kembalikan')

@endsection
