@extends('layouts.admin')

@section('title', 'Laporan Pengembalian - Admin')

@section('content')
<div class="max-w-7xl mx-auto">

    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white">Laporan Pengembalian Buku</h1>
            <p class="text-gray-400 mt-1">Riwayat pengembalian dan denda</p>
        </div>

        <!-- Tombol Export -->
        <div class="flex gap-3">
            <a href="{{ route('admin.laporan.export.pdf') }}"
               class="bg-red-600 hover:bg-red-700 px-5 py-3 rounded-2xl flex items-center gap-2 transition">
                <i class="fas fa-file-pdf"></i>
                <span>Export PDF</span>
            </a>
            <a href="{{ route('admin.laporan.export.excel') }}"
               class="bg-emerald-600 hover:bg-emerald-700 px-5 py-3 rounded-2xl flex items-center gap-2 transition">
                <i class="fas fa-file-excel"></i>
                <span>Export Excel</span>
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-500/10 border border-green-500 text-green-400 px-5 py-4 rounded-2xl mb-6 flex items-center gap-3">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Search & Filter -->
    <div class="bg-gray-800 rounded-3xl p-5 mb-6">
        <form method="GET" class="flex flex-wrap gap-4">
            <div class="flex-1">
                <input type="text" name="search"
                       class="w-full bg-gray-900 border border-gray-700 rounded-2xl px-5 py-3.5 focus:outline-none focus:border-blue-500 text-white placeholder-gray-500"
                       placeholder="Cari nama siswa atau judul buku..."
                       value="{{ request('search') }}">
            </div>

            <!-- Filter Tanggal -->
            <div class="flex gap-3">
                <div>
                    <input type="date" name="tanggal_awal"
                           class="bg-gray-900 border border-gray-700 rounded-2xl px-5 py-3.5 focus:outline-none focus:border-blue-500 text-white"
                           value="{{ request('tanggal_awal') }}">
                </div>
                <div class="flex items-center text-gray-400">s/d</div>
                <div>
                    <input type="date" name="tanggal_akhir"
                           class="bg-gray-900 border border-gray-700 rounded-2xl px-5 py-3.5 focus:outline-none focus:border-blue-500 text-white"
                           value="{{ request('tanggal_akhir') }}">
                </div>
            </div>

            <!-- Filter Status -->
            <div class="w-64">
                <select name="status"
                        class="w-full bg-gray-900 border border-gray-700 rounded-2xl px-5 py-3.5 focus:outline-none focus:border-blue-500 text-white">
                    <option value="">Semua Status</option>
                    <option value="Dikembalikan" {{ request('status') == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                    <option value="Diterima" {{ request('status') == 'Diterima' ? 'selected' : '' }}>Masih Dipinjam</option>
                </select>
            </div>

            <button type="submit"
                    class="bg-gray-700 hover:bg-gray-600 px-8 rounded-2xl transition text-white">
                <i class="fas fa-filter"></i>
            </button>
        </form>
    </div>

    <!-- Table (sama seperti sebelumnya) -->
    <div class="bg-gray-800 rounded-3xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1200px]">
                <thead>
                    <tr class="border-b border-gray-700">
                        <th class="text-left py-5 px-6 text-gray-400 font-medium w-12">No</th>
                        <th class="text-left py-5 px-6 text-gray-400 font-medium">Nama Siswa</th>
                        <th class="text-left py-5 px-6 text-gray-400 font-medium">Kelas</th>
                        <th class="text-left py-5 px-6 text-gray-400 font-medium">Buku</th>
                        <th class="text-left py-5 px-6 text-gray-400 font-medium">Jumlah</th>
                        <th class="text-left py-5 px-6 text-gray-400 font-medium">Tanggal Pinjam</th>
                        <th class="text-left py-5 px-6 text-gray-400 font-medium">Batas Kembali</th>
                        <th class="text-left py-5 px-6 text-gray-400 font-medium">Tanggal Dikembalikan</th>
                        <th class="text-center py-5 px-6 text-gray-400 font-medium w-32">Denda</th>
                        <th class="text-center py-5 px-6 text-gray-400 font-medium w-36">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach($laporan as $index => $p)
                    <tr class="hover:bg-gray-700/50 transition">
                        <td class="py-5 px-6 text-gray-300">{{ $index + 1 + ($laporan->currentPage()-1)*$laporan->perPage() }}</td>
                        <td class="py-5 px-6 font-medium text-white">{{ $p->user->nama ?? 'N/A' }}</td>
                        <td class="py-5 px-6 text-gray-300">{{ $p->user->kelas ?? '-' }}</td>
                        <td class="py-5 px-6 text-gray-300">{{ $p->book->judul }}</td>
                        <td class="py-5 px-6 text-gray-300">{{ $p->jumlah }}</td>
                        <td class="py-5 px-6 text-gray-300">{{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('d M Y') }}</td>
                        <td class="py-5 px-6 text-gray-300">{{ \Carbon\Carbon::parse($p->tgl_kembali)->format('d M Y') }}</td>
                        <td class="py-5 px-6 text-gray-300">
                            {{ $p->tgl_kembali_actual ? \Carbon\Carbon::parse($p->tgl_kembali_actual)->format('d M Y') : '-' }}
                        </td>
                        <td class="py-5 px-6 text-center font-medium">
                            @if($p->denda > 0)
                                <span class="text-red-400">Rp {{ number_format($p->denda, 0, ',', '.') }}</span>
                            @else
                                <span class="text-emerald-400">-</span>
                            @endif
                        </td>
                        <td class="py-5 px-6 text-center">
                            @if($p->status == 'Dikembalikan')
                                <span class="inline-block px-5 py-1.5 bg-blue-500/20 text-blue-400 text-sm font-medium rounded-2xl">Dikembalikan</span>
                            @elseif($p->status == 'Diterima')
                                <span class="inline-block px-5 py-1.5 bg-emerald-500/20 text-emerald-400 text-sm font-medium rounded-2xl">Dipinjam</span>
                            @elseif($p->status == 'Menunggu')
                                <span class="inline-block px-5 py-1.5 bg-yellow-500/20 text-yellow-400 text-sm font-medium rounded-2xl">Menunggu</span>
                            @else
                                <span class="inline-block px-5 py-1.5 bg-red-500/20 text-red-400 text-sm font-medium rounded-2xl">Ditolak</span>
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
        @if($laporan->hasPages())
            {{ $laporan->links('pagination::tailwind') }}
        @endif
    </div>

</div>
@endsection
