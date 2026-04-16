<!-- Header -->
<header class="bg-blue-600 text-white shadow-lg border-b border-blue-700 content-wrapper">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <i class="fas fa-book text-2xl"></i>
            <h1 class="text-2xl font-bold tracking-tight">PIJAM Admin</h1>
        </div>

        <div class="flex items-center gap-5">
            <div class="flex items-center gap-2 bg-blue-700/50 px-4 py-2 rounded-2xl">
                <span class="text-sm font-medium">{{ Auth::user()->email }}</span>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="bg-red-500 hover:bg-red-600 px-5 py-2.5 rounded-2xl text-sm font-medium transition flex items-center gap-2">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </button>
            </form>
        </div>
    </div>
</header>
