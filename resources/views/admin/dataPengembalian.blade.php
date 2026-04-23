@extends('layouts.admin')

@section('title', 'Data Pengembalian - Admin')

@section('content')
<div class="max-w-7xl mx-auto">

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white">Data Pengembalian</h1>
            <p class="text-gray-400 mt-1">Konfirmasi pengembalian buku dari anggota</p>
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

    <!-- Search Bar -->
    <div class="mb-6">
        <form method="GET" action="{{ route('admin.dataPengembalian') }}" class="flex gap-3">
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Cari nama anggota, kelas, atau judul buku..."
                   class="flex-1 bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-2 focus:outline-none focus:border-blue-500">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-xl text-white transition">Cari</button>
            @if(request('search'))
                <a href="{{ route('admin.dataPengembalian') }}" class="bg-gray-600 hover:bg-gray-700 px-4 py-2 rounded-xl text-white transition">Reset</a>
            @endif
        </form>
    </div>

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
                        <th class="text-left py-5 px-6 text-gray-400 font-medium">Jumlah</th>
                        <th class="text-center py-5 px-6 text-gray-400 font-medium">Tgl Pinjam</th>
                        <th class="text-center py-5 px-6 text-gray-400 font-medium">Tgl Kembali (Batas)</th>
                        <th class="text-center py-5 px-6 text-gray-400 font-medium">Tgl Dikembalikan</th>
                        <th class="text-center py-5 px-6 text-gray-400 font-medium w-32">Status</th>
                        <th class="text-center py-5 px-6 text-gray-400 font-medium w-40">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($pengembalian as $index => $pinjam)
                    <tr class="hover:bg-gray-700/50 transition">
                        <td class="py-5 px-6 text-gray-300">{{ $loop->iteration + ($pengembalian->currentPage() - 1) * $pengembalian->perPage() }}</td>
                        <td class="py-5 px-6 font-medium text-white">{{ $pinjam->user->nama }}</td>
                        <td class="py-5 px-6 text-gray-300">{{ $pinjam->user->kelas }}</td>
                        <td class="py-5 px-6 text-gray-300">{{ $pinjam->book->judul }}</td>
                        <td class="py-5 px-6 text-gray-300">{{ $pinjam->jumlah }}</td>
                        <td class="py-5 px-6 text-center text-gray-300">{{ $pinjam->tgl_pinjam ? \Carbon\Carbon::parse($pinjam->tgl_pinjam)->format('d M Y') : '-' }}</td>
                        <td class="py-5 px-6 text-center text-gray-300">{{ $pinjam->tgl_kembali ? \Carbon\Carbon::parse($pinjam->tgl_kembali)->format('d M Y') : '-' }}</td>
                        <td class="py-5 px-6 text-center text-gray-300">{{ $pinjam->tgl_kembali_actual ? \Carbon\Carbon::parse($pinjam->tgl_kembali_actual)->format('d M Y') : '-' }}</td>
                        <td class="py-5 px-6 text-center">
                            @if($pinjam->status == 'Menunggu Pengembalian')
                                <span class="inline-block px-4 py-1.5 bg-orange-500/20 text-orange-400 text-sm font-medium rounded-2xl">Menunggu Konfirmasi</span>
                            @else
                                <span class="inline-block px-4 py-1.5 bg-green-500/20 text-green-400 text-sm font-medium rounded-2xl">Dikembalikan</span>
                            @endif
                        </td>
                        <td class="py-5 px-6 text-center">
                            @if($pinjam->status == 'Menunggu Pengembalian')
                                <form action="{{ route('admin.pengembalian.terima', $pinjam) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-xl text-sm font-medium text-white transition">Konfirmasi</button>
                                </form>
                            @else
                                <span class="text-gray-500 text-sm">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="py-16 text-center text-gray-500">
                            <i class="fas fa-inbox text-4xl mb-3 block"></i>
                            Tidak ada data pengembalian.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($pengembalian->hasPages())
    <div class="mt-8 flex justify-center">
        {{ $pengembalian->links('pagination::tailwind') }}
    </div>
    @endif

</div>
@endsection
