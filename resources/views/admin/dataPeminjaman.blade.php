@extends('layouts.admin')

@section('title', 'Data Peminjaman - Admin')

@section('content')
<div class="max-w-7xl mx-auto">

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white">Data Peminjaman</h1>
            <p class="text-gray-400 mt-1">Kelola permintaan peminjaman buku</p>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-500/10 border border-green-500 text-green-400 px-5 py-4 rounded-2xl mb-6 flex items-center gap-3">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-500/10 border border-red-500 text-red-400 px-5 py-4 rounded-2xl mb-6 flex items-center gap-3">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- Table -->
    <div class="bg-gray-800 rounded-3xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1200px]">
                <thead>
                    <tr class="border-b border-gray-700">
                        <th class="text-left py-5 px-6 text-gray-400 font-medium w-12">No</th>
                        <th class="text-left py-5 px-6 text-gray-400 font-medium">Nama Anggota</th>
                        <th class="text-left py-5 px-6 text-gray-400 font-medium">Kelas</th>
                        <th class="text-left py-5 px-6 text-gray-400 font-medium">Buku</th>
                        <th class="text-center py-5 px-6 text-gray-400 font-medium">Tgl Pinjam</th>
                        <th class="text-center py-5 px-6 text-gray-400 font-medium">Tgl Kembali</th>
                        <th class="text-center py-5 px-6 text-gray-400 font-medium w-32">Status</th>
                        <th class="text-center py-5 px-6 text-gray-400 font-medium w-40">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach($peminjaman as $index => $pinjam)
                    <tr class="hover:bg-gray-700/50 transition">
                        <td class="py-5 px-6 text-gray-300">{{ $index + 1 + ($peminjaman->currentPage()-1)*$peminjaman->perPage() }}</td>
                        <td class="py-5 px-6 font-medium text-white">{{ $pinjam->user->nama }}</td>
                        <td class="py-5 px-6 text-gray-300">{{ $pinjam->user->kelas }}</td>
                        <td class="py-5 px-6 text-gray-300">{{ $pinjam->book->judul }}</td>
                        <td class="py-5 px-6 text-center text-gray-300">{{ $pinjam->tgl_pinjam ? \Carbon\Carbon::parse($pinjam->tgl_pinjam)->format('d M Y') : '-' }}</td>
                        <td class="py-5 px-6 text-center text-gray-300">{{ $pinjam->tgl_kembali ? \Carbon\Carbon::parse($pinjam->tgl_kembali)->format('d M Y') : 'Belum dikembalikan' }}</td>
                        <td class="py-5 px-6 text-center">
                            @if($pinjam->status == 'Menunggu')
                                <span class="inline-block px-5 py-1.5 bg-yellow-500/20 text-yellow-400 text-sm font-medium rounded-2xl">Menunggu</span>
                            @elseif($pinjam->status == 'Diterima')
                                <span class="inline-block px-5 py-1.5 bg-emerald-500/20 text-emerald-400 text-sm font-medium rounded-2xl">Diterima</span>
                            @elseif($pinjam->status == 'Dikembalikan')
                                <span class="inline-block px-5 py-1.5 bg-blue-500/20 text-blue-400 text-sm font-medium rounded-2xl">Dikembalikan</span>
                            @else
                                <span class="inline-block px-5 py-1.5 bg-red-500/20 text-red-400 text-sm font-medium rounded-2xl">Ditolak</span>
                            @endif
                        </td>
                        <td class="py-5 px-6 text-center">
                            @if($pinjam->status == 'Menunggu')
                                <div class="flex items-center justify-center gap-3">
                                    <form action="{{ route('admin.peminjaman.terima', $pinjam) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="bg-emerald-600 hover:bg-emerald-700 px-4 py-2 rounded-xl text-sm font-medium transition">
                                            Terima
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.peminjaman.tolak', $pinjam) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-xl text-sm font-medium transition"
                                                onclick="return confirm('Yakin tolak peminjaman ini?')">
                                            Tolak
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="text-gray-500 text-sm">Sudah diproses</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-8 flex justify-center">
        @if($peminjaman->hasPages())
            {{ $peminjaman->links('pagination::tailwind') }}
        @endif
    </div>

</div>
@endsection
