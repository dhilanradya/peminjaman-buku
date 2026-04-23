@extends('layouts.admin')

@section('title', 'Data Denda - Admin')

@section('content')
<div class="max-w-7xl mx-auto">

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white">Data Denda</h1>
            <p class="text-gray-400 mt-1">Kelola pembayaran denda keterlambatan</p>
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

    <div class="bg-gray-800 rounded-3xl overflow-hidden">
        <div class="overflow-x-auto">
            {{-- Search & Filter --}}
        <form method="GET" class="mb-6 flex gap-3">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari nama anggota, kelas, atau buku..."
                class="flex-1 px-4 py-3 rounded-2xl bg-gray-700 border border-gray-600 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500">

            <select name="status_denda"
                    class="px-4 py-3 rounded-2xl bg-gray-700 border border-gray-600 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Status</option>
                <option value="Belum Dibayar" {{ request('status_denda') == 'Belum Dibayar' ? 'selected' : '' }}>Belum Dibayar</option>
                <option value="Sudah Dibayar" {{ request('status_denda') == 'Sudah Dibayar' ? 'selected' : '' }}>Sudah Dibayar</option>
            </select>

            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 px-6 py-3 rounded-2xl text-sm font-medium transition">
                <i class="fas fa-search mr-2"></i>Cari
            </button>

            @if(request('search') || request('status_denda'))
                <a href="{{ route('admin.dataDenda') }}"
                class="bg-gray-600 hover:bg-gray-500 px-6 py-3 rounded-2xl text-sm font-medium transition">
                    <i class="fas fa-times mr-2"></i>Reset
                </a>
            @endif
        </form>
            <table class="w-full min-w-[1100px]">
                <thead>
                    <tr class="border-b border-gray-700">
                        <th class="text-left py-5 px-6 text-gray-400 font-medium w-12">No</th>
                        <th class="text-left py-5 px-6 text-gray-400 font-medium">Nama Anggota</th>
                        <th class="text-left py-5 px-6 text-gray-400 font-medium">Kelas</th>
                        <th class="text-left py-5 px-6 text-gray-400 font-medium">Buku</th>
                        <th class="text-center py-5 px-6 text-gray-400 font-medium">Batas Kembali</th>
                        <th class="text-center py-5 px-6 text-gray-400 font-medium">Tgl Dikembalikan</th>
                        <th class="text-center py-5 px-6 text-gray-400 font-medium">Keterlambatan</th>
                        <th class="text-center py-5 px-6 text-gray-400 font-medium">Denda</th>
                        <th class="text-center py-5 px-6 text-gray-400 font-medium w-36">Status Denda</th>
                        <th class="text-center py-5 px-6 text-gray-400 font-medium w-40">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($dendaList as $index => $pinjam)
                    @php
                        $telat = \Carbon\Carbon::parse($pinjam->tgl_kembali)
                                    ->diffInDays(\Carbon\Carbon::parse($pinjam->tgl_kembali_actual));
                    @endphp
                    <tr class="hover:bg-gray-700/50 transition">
                        <td class="py-5 px-6 text-gray-300">
                            {{ $index + 1 + ($dendaList->currentPage()-1)*$dendaList->perPage() }}
                        </td>
                        <td class="py-5 px-6 font-medium text-white">{{ $pinjam->user->nama }}</td>
                        <td class="py-5 px-6 text-gray-300">{{ $pinjam->user->kelas }}</td>
                        <td class="py-5 px-6 text-gray-300">{{ $pinjam->book->judul }}</td>
                        <td class="py-5 px-6 text-center text-gray-300">
                            {{ \Carbon\Carbon::parse($pinjam->tgl_kembali)->format('d M Y') }}
                        </td>
                        <td class="py-5 px-6 text-center text-gray-300">
                            {{ \Carbon\Carbon::parse($pinjam->tgl_kembali_actual)->format('d M Y') }}
                        </td>
                        <td class="py-5 px-6 text-center text-red-400 font-medium">
                            {{ $telat }} hari
                        </td>
                        <td class="py-5 px-6 text-center text-red-400 font-semibold">
                            Rp {{ number_format($pinjam->denda, 0, ',', '.') }}
                        </td>
                        <td class="py-5 px-6 text-center">
                            @if($pinjam->status_denda === 'Belum Dibayar')
                                <span class="inline-block px-4 py-1.5 bg-red-500/20 text-red-400 text-sm font-medium rounded-2xl">
                                    Belum Dibayar
                                </span>
                            @else
                                <span class="inline-block px-4 py-1.5 bg-emerald-500/20 text-emerald-400 text-sm font-medium rounded-2xl">
                                    Sudah Dibayar
                                </span>
                            @endif
                        </td>
                        <td class="py-5 px-6 text-center">
                            @if($pinjam->status_denda === 'Belum Dibayar')
                                <form action="{{ route('admin.denda.konfirmasi', $pinjam) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="bg-emerald-600 hover:bg-emerald-700 px-4 py-2 rounded-xl text-sm font-medium text-white transition">
                                        Konfirmasi Bayar
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-500 text-sm">Lunas</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="py-16 text-center text-gray-500">
                            <i class="fas fa-check-circle text-4xl mb-3 block text-emerald-500"></i>
                            Tidak ada data denda.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-8 flex justify-center">
        @if($dendaList->hasPages())
            {{ $dendaList->links('pagination::tailwind') }}
        @endif
    </div>

</div>
@endsection
