@extends('layouts.user')

@section('title', 'Riwayat Peminjaman')

@section('content')
<div class="max-w-7xl mx-auto px-6">
    <h1 class="text-4xl font-bold mb-8">Riwayat Peminjaman</h1>

    <div class="bg-gray-800 rounded-3xl overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-700">
                    <th class="text-left py-5 px-6">Buku</th>
                    <th class="text-left py-5 px-6">Tanggal Pinjam</th>
                    <th class="text-left py-5 px-6">Batas Kembali</th>
                    <th class="text-left py-5 px-6">Tanggal Dikembalikan</th>
                    <th class="text-center py-5 px-6">Denda</th>
                    <th class="text-center py-5 px-6">Status</th>
                    <th class="text-center py-5 px-6">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @foreach($riwayat as $p)
                <tr>
                    <td class="py-5 px-6 font-medium">{{ $p->book->judul }}</td>
                    <td class="py-5 px-6">{{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('d M Y') }}</td>
                    <td class="py-5 px-6">{{ \Carbon\Carbon::parse($p->tgl_kembali)->format('d M Y') }}</td>
                    <td class="py-5 px-6">
                        {{ $p->tgl_kembali_actual ? \Carbon\Carbon::parse($p->tgl_kembali_actual)->format('d M Y') : '-' }}
                    </td>
                    <td class="py-5 px-6 text-center font-medium">
                        @if($p->denda > 0)
                            <span class="text-red-400 font-semibold">Rp {{ number_format($p->denda, 0, ',', '.') }}</span>
                        @else
                            <span class="text-emerald-400">-</span>
                        @endif
                    </td>
                    <td class="py-5 px-6 text-center">
                        @if($p->status == 'Menunggu')
                            <span class="bg-yellow-500/20 text-yellow-400 px-4 py-1 rounded-2xl text-sm">Menunggu</span>
                        @elseif($p->status == 'Diterima')
                            <span class="bg-emerald-500/20 text-emerald-400 px-4 py-1 rounded-2xl text-sm">Dipinjam</span>
                        @elseif($p->status == 'Dikembalikan')
                            <span class="bg-blue-500/20 text-blue-400 px-4 py-1 rounded-2xl text-sm">Dikembalikan</span>
                        @else
                            <span class="bg-red-500/20 text-red-400 px-4 py-1 rounded-2xl text-sm">Ditolak</span>
                        @endif
                    </td>
                    <td class="py-5 px-6 text-center">
                        @if($p->status == 'Diterima')
                            <form action="{{ route('user.kembalikan', $p) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        onclick="return confirm('Yakin ingin mengembalikan buku ini?')"
                                        class="bg-blue-600 hover:bg-blue-700 px-5 py-2 rounded-2xl text-sm font-medium">
                                    Kembalikan
                                </button>
                            </form>
                        @else
                            <span class="text-gray-500">—</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $riwayat->links('pagination::tailwind') }}
    </div>
</div>
@endsection
