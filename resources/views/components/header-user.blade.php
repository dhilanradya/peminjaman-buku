<!-- Header User -->
<header class="bg-gray-900 border-b border-gray-800 fixed top-0 left-0 right-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-5">

        <!-- Logo + Nama Aplikasi di Tengah -->
        <div class="flex items-center justify-center gap-4 mb-6">
            <i class="fas fa-book-open text-4xl text-blue-500"></i>
            <div class="text-center">
                <h1 class="text-3xl font-bold tracking-tight text-white">PIJAM</h1>
                <p class="text-blue-400 text-sm -mt-1">Peminjaman Buku</p>
            </div>
        </div>

        <!-- Navigation di Tengah -->
        <nav class="flex items-center justify-center gap-10 text-lg">
            <a href="{{ route('user.dashboard') }}"
               class="flex items-center gap-2 font-medium hover:text-blue-400 transition pb-1
                      {{ request()->routeIs('user.dashboard') ? 'text-blue-400 border-b-2 border-blue-400' : 'text-gray-400' }}">
                <i class="fas fa-tachometer-alt"></i>
                Dashboard
            </a>
            <a href="{{ route('user.buku') }}"
               class="flex items-center gap-2 font-medium hover:text-blue-400 transition pb-1
                      {{ request()->routeIs('user.buku') ? 'text-blue-400 border-b-2 border-blue-400' : 'text-gray-400' }}">
                <i class="fas fa-book"></i>
                Buku
            </a>

            <a href="{{ route('user.riwayat') }}"
               class="flex items-center gap-2 font-medium hover:text-blue-400 transition pb-1
                      {{ request()->routeIs('user.riwayat') ? 'text-blue-400 border-b-2 border-blue-400' : 'text-gray-400' }}">
                <i class="fas fa-history"></i>
                Riwayat Peminjaman
            </a>
        </nav>

        <!-- Logout di Pojok Kanan -->
        <div class="absolute top-6 right-6">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="flex items-center gap-2 bg-red-600 hover:bg-red-700 px-5 py-2.5 rounded-2xl text-sm font-medium transition">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </button>
            </form>
        </div>

    </div>
</header>
