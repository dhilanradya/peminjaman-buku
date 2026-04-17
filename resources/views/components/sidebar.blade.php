<!-- Sidebar -->
<aside class="w-64 bg-gray-800 text-white min-h-screen fixed left-0 top-0 flex flex-col shadow-xl">

    <!-- Sidebar Header -->
    <div class="p-6 border-b border-gray-700 bg-gray-800">
        <div class="flex items-center gap-3">
            <i class="fas fa-book-open text-3xl text-blue-400"></i>
            <div>
                <h2 class="text-xl font-bold">PIJAM</h2>
                <p class="text-xs text-gray-400 -mt-1">Admin Panel</p>
            </div>
        </div>
    </div>

    <!-- Menu -->
    <nav class="flex-1 px-3 py-6 space-y-1">
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-3 px-5 py-3.5 rounded-2xl hover:bg-gray-700 transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-200 hover:text-white' }}">
            <i class="fas fa-tachometer-alt text-2xl text-blue-400 w-8"></i>
            <span class="font-medium">Dashboard</span>
        </a>

        <a href="{{ route('admin.dataBuku') }}"
           class="flex items-center gap-3 px-5 py-3.5 rounded-2xl hover:bg-gray-700 transition-all {{ request()->routeIs('admin.dataBuku') ? 'bg-blue-600 text-white' : 'text-gray-200 hover:text-white' }}">
            <i class="fas fa-book text-2xl text-blue-400 w-8"></i>
            <span class="font-medium">Data Buku</span>
        </a>

        <a href="{{ route('admin.dataKategori') }}"
            class="flex items-center gap-3 px-5 py-3.5 rounded-2xl hover:bg-gray-700 transition-all {{ request()->routeIs('admin.dataKategori') ? 'bg-blue-600 text-white' : 'text-gray-200 hover:text-white' }}">
            <i class="fas fa-tags text-2xl text-pink-400 w-8"></i>
            <span class="font-medium">Kategori</span>
        </a>

        <a href="{{ route('admin.dataAnggota') }}"
           class="flex items-center gap-3 px-5 py-3.5 rounded-2xl hover:bg-gray-700 transition-all {{ request()->routeIs('admin.dataAnggota') ? 'bg-blue-600 text-white' : 'text-gray-200 hover:text-white' }}">
            <i class="fas fa-users text-2xl text-blue-400 w-8"></i>
            <span class="font-medium">Data Anggota</span>
        </a>

        <a href="{{ route('admin.dataPeminjaman') }}"
           class="flex items-center gap-3 px-5 py-3.5 rounded-2xl hover:bg-gray-700 transition-all {{ request()->routeIs('admin.dataPeminjaman') ? 'bg-blue-600 text-white' : 'text-gray-200 hover:text-white' }}">
            <i class="fas fa-hand-holding text-2xl text-emerald-400 w-8"></i>
            <span class="font-medium">Peminjaman</span>
        </a>

        <a href="#"
           class="flex items-center gap-3 px-5 py-3.5 rounded-2xl hover:bg-gray-700 transition-all text-gray-200 hover:text-white">
            <i class="fas fa-chart-bar text-2xl text-violet-400 w-8"></i>
            <span class="font-medium">Laporan</span>
        </a>
    </nav>

    <!-- Sidebar Footer -->
    <div class="p-5 border-t border-gray-600 bg-gray-800 text-xs text-gray-400 text-center">
        © {{ date('Y') }} PIJAM - Admin System
    </div>
</aside>
