@extends('layouts.user')

@section('title', 'Profile - User')

@section('content')
<div class="max-w-2xl mx-auto px-6 py-10">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white">Profile Saya</h1>
        <p class="text-gray-400 mt-1">Informasi data diri Anda</p>
    </div>

    <div class="bg-gray-800 rounded-3xl border border-gray-700 overflow-hidden">

        <!-- Avatar & Nama -->
        <div class="bg-gradient-to-r from-blue-600/30 to-blue-800/20 px-8 py-8 flex items-center gap-6 border-b border-gray-700">
            <div class="w-20 h-20 rounded-full bg-blue-600 flex items-center justify-center text-3xl font-bold text-white shrink-0">
                {{ strtoupper(substr($user->nama ?? $user->email, 0, 1)) }}
            </div>
            <div>
                <h2 class="text-2xl font-bold text-white">{{ $user->nama ?? '-' }}</h2>
                <span class="inline-block mt-1 px-3 py-1 bg-blue-600/30 text-blue-400 text-xs font-medium rounded-full border border-blue-500/30">
                    Anggota Perpustakaan
                </span>
            </div>
        </div>

        <!-- Data Detail -->
        <div class="px-8 py-6 space-y-5">

            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-gray-700 flex items-center justify-center shrink-0">
                    <i class="fas fa-id-card text-blue-400"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide">NIS</p>
                    <p class="text-white font-medium">{{ $user->nis ?? '-' }}</p>
                </div>
            </div>

            <div class="h-px bg-gray-700"></div>

            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-gray-700 flex items-center justify-center shrink-0">
                    <i class="fas fa-envelope text-blue-400"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Email</p>
                    <p class="text-white font-medium">{{ $user->email }}</p>
                </div>
            </div>

            <div class="h-px bg-gray-700"></div>

            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-gray-700 flex items-center justify-center shrink-0">
                    <i class="fas fa-chalkboard text-blue-400"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Kelas</p>
                    <p class="text-white font-medium">{{ $user->kelas ?? '-' }}</p>
                </div>
            </div>

            <div class="h-px bg-gray-700"></div>

            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-gray-700 flex items-center justify-center shrink-0">
                    <i class="fas fa-phone text-blue-400"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide">No. HP</p>
                    <p class="text-white font-medium">{{ $user->no_hp ?? '-' }}</p>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
