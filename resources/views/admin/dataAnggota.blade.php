@extends('layouts.admin')

@section('title', 'Data Anggota - Admin')

@section('content')
<div class="max-w-7xl mx-auto">

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white">Data Anggota</h1>
            <p class="text-gray-400 mt-1">Kelola data anggota perpustakaan</p>
        </div>
        <a href="{{ route('admin.tambahAnggota') }}"
           class="bg-blue-600 hover:bg-blue-700 px-6 py-3 rounded-2xl flex items-center gap-2 transition-all">
            <i class="fas fa-plus"></i>
            <span>Tambah Anggota</span>
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-500/10 border border-green-500 text-green-400 px-5 py-4 rounded-2xl mb-6 flex items-center gap-3">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Search -->
    <div class="bg-gray-800 rounded-3xl p-5 mb-6">
        <form method="GET" class="flex gap-4">
            <div class="flex-1">
                <input type="text" name="search"
                       class="w-full bg-gray-900 border border-gray-700 rounded-2xl px-5 py-3.5 focus:outline-none focus:border-blue-500 text-white placeholder-gray-500"
                       placeholder="Cari nama, NIS, email, atau kelas..."
                       value="{{ request('search') }}">
            </div>
            <button type="submit"
                    class="bg-gray-700 hover:bg-gray-600 px-8 rounded-2xl transition text-white">
                <i class="fas fa-search"></i>
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
                        <th class="text-left py-5 px-6 text-gray-400 font-medium">Nama</th>
                        <th class="text-left py-5 px-6 text-gray-400 font-medium">NIS</th>
                        <th class="text-left py-5 px-6 text-gray-400 font-medium">Kelas</th>
                        <th class="text-left py-5 px-6 text-gray-400 font-medium">No. HP</th>
                        <th class="text-left py-5 px-6 text-gray-400 font-medium">Email</th>
                        <th class="text-center py-5 px-6 text-gray-400 font-medium w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach($members as $index => $member)
                    <tr class="hover:bg-gray-700/50 transition">
                        <td class="py-5 px-6 text-gray-300">{{ $index + 1 + ($members->currentPage()-1)*$members->perPage() }}</td>
                        <td class="py-5 px-6 font-medium text-white">{{ $member->nama }}</td>
                        <td class="py-5 px-6 text-gray-300">{{ $member->nis }}</td>
                        <td class="py-5 px-6 text-gray-300">{{ $member->kelas }}</td>
                        <td class="py-5 px-6 text-gray-300">{{ $member->no_hp }}</td>
                        <td class="py-5 px-6 text-gray-300">{{ $member->email }}</td>
                        <td class="py-5 px-6 text-center">
                            <div class="flex items-center justify-center gap-5">
                                <a href="{{ route('admin.editAnggota', $member) }}"
                                   class="text-amber-400 hover:text-amber-300 hover:scale-110 transition">
                                    <i class="fas fa-edit text-xl"></i>
                                </a>
                                <form action="{{ route('admin.hapusAnggota', $member) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Yakin ingin menghapus anggota ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300 hover:scale-110 transition">
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

    <div class="mt-8 flex justify-center">
        @if($members->hasPages())
            {{ $members->links('pagination::tailwind') }}
        @endif
    </div>

</div>
@endsection
