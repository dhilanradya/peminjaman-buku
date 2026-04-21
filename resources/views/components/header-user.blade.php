<!-- Header User -->
<header class="bg-gray-900 border-b border-gray-800 fixed top-0 left-0 right-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-5 relative">

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

        <!-- Menu Hamburger di Pojok Kanan -->
        <div class="absolute top-6 right-6" x-data="{ open: false }">
            <button @click="open = !open"
                    class="flex items-center justify-center w-11 h-11 rounded-2xl bg-gray-800 border border-gray-700 hover:border-blue-500 transition text-white">
                <i class="fas fa-bars text-lg"></i>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="open"
                 @click.outside="open = false"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                 class="absolute right-0 mt-2 w-48 bg-gray-800 border border-gray-700 rounded-2xl shadow-xl overflow-hidden">

                <!-- Info User -->
                <div class="px-4 py-3 border-b border-gray-700">
                    <p class="text-xs text-gray-500">Login sebagai</p>
                    <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->nama ?? Auth::user()->email }}</p>
                </div>

                <!-- Profile -->
                <a href="{{ route('user.profile') }}"
                   class="flex items-center gap-3 px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition">
                    <i class="fas fa-user-circle text-blue-400 w-4"></i>
                    <span class="text-sm font-medium">Profile</span>
                </a>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center gap-3 px-4 py-3 text-gray-300 hover:bg-red-600/20 hover:text-red-400 transition">
                        <i class="fas fa-sign-out-alt text-red-400 w-4"></i>
                        <span class="text-sm font-medium">Logout</span>
                    </button>
                </form>
            </div>
        </div>

    </div>
</header>
