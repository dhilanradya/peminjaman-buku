@extends('layouts.admin')

@section('title', 'Dashboard - Admin')

@section('content')
<div class="min-h-screen bg-gray-900 p-6">

    <div class="max-w-7xl mx-auto">

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white">Dashboard Admin</h1>
            <p class="text-gray-400 mt-2">Selamat datang di sistem PIJAM</p>
        </div>

        <!-- Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            <!-- Card -->
            <div class="bg-gray-800/90 backdrop-blur-lg border border-gray-700 rounded-2xl p-6 shadow-xl hover:scale-105 transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Total Barang</p>
                        <h2 class="text-2xl font-bold text-white mt-1">120</h2>
                    </div>
                    <div class="bg-gradient-to-r from-blue-500 to-sky-600 p-3 rounded-xl text-white">
                        <i class="fas fa-box"></i>
                    </div>
                </div>
            </div>

            <!-- Card -->
            <div class="bg-gray-800/90 backdrop-blur-lg border border-gray-700 rounded-2xl p-6 shadow-xl hover:scale-105 transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Peminjaman</p>
                        <h2 class="text-2xl font-bold text-white mt-1">45</h2>
                    </div>
                    <div class="bg-gradient-to-r from-blue-500 to-sky-600 p-3 rounded-xl text-white">
                        <i class="fas fa-hand-holding"></i>
                    </div>
                </div>
            </div>

            <!-- Card -->
            <div class="bg-gray-800/90 backdrop-blur-lg border border-gray-700 rounded-2xl p-6 shadow-xl hover:scale-105 transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Pengembalian</p>
                        <h2 class="text-2xl font-bold text-white mt-1">30</h2>
                    </div>
                    <div class="bg-gradient-to-r from-blue-500 to-sky-600 p-3 rounded-xl text-white">
                        <i class="fas fa-undo"></i>
                    </div>
                </div>
            </div>

            <!-- Card -->
            <div class="bg-gray-800/90 backdrop-blur-lg border border-gray-700 rounded-2xl p-6 shadow-xl hover:scale-105 transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">User</p>
                        <h2 class="text-2xl font-bold text-white mt-1">20</h2>
                    </div>
                    <div class="bg-gradient-to-r from-blue-500 to-sky-600 p-3 rounded-xl text-white">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>

        </div>

        <!-- Section tambahan -->
        <div class="mt-10 bg-gray-800/90 backdrop-blur-lg border border-gray-700 rounded-2xl p-6 shadow-xl">
            <h2 class="text-xl font-semibold text-white mb-4">Aktivitas Terbaru</h2>

            <div class="text-gray-400 text-sm">
                Belum ada aktivitas terbaru...
            </div>
        </div>

    </div>

</div>
@endsection
