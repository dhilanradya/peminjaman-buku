<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PIJAM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            background-image: url('https://stanforddaily.com/wp-content/uploads/2018/05/building-aisle-library-public-library-inventory-bookselling-24143-pxhere.com_.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
        }
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.65);
            z-index: -1;
        }
        .glass {
            background: rgba(55, 65, 81, 0.95);
            backdrop-filter: blur(12px);
        }

        /* Fix Input Autofill agar tetap abu-abu gelap */
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-text-fill-color: white !important;
            -webkit-box-shadow: 0 0 0 30px #374151 inset !important;
            transition: background-color 5000s ease-in-out 0s;
        }

        .alert {
            animation: fadeIn 0.4s ease-in;
        }
        @keyframes fadeOut {
            from { opacity: 1; transform: translateY(0); }
            to { opacity: 0; transform: translateY(-10px); }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center">

    <div class="max-w-md w-full mx-4">
        <!-- Card Login -->
        <div class="glass rounded-3xl shadow-2xl overflow-hidden border border-gray-600">

            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-500 to-sky-600 p-8 text-white text-center">
                <i class="fas fa-book-open text-5xl mb-4"></i>
                <h1 class="text-3xl font-bold">PIJAM</h1>
                <p class="text-sky-100 mt-2">Selamat Datang</p>
            </div>

            <!-- Form -->
            <div class="p-8">

                <!-- Alert Error -->
                @if (session('error'))
                    <div id="error-alert" class="alert bg-red-600 text-white px-5 py-4 rounded-2xl mb-6 flex items-center gap-3">
                        <i class="fas fa-exclamation-circle text-xl"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <!-- Alert Success -->
                @if (session('success'))
                    <div id="success-alert" class="alert bg-green-600 text-white px-5 py-4 rounded-2xl mb-6 flex items-center gap-3">
                        <i class="fas fa-check-circle text-xl"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-6">
                        <label class="block text-gray-200 font-medium mb-2">Email</label>
                        <div class="relative">
                            <span class="absolute left-3 top-3.5 text-gray-400">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email"
                                   name="email"
                                   placeholder="Masukkan email anda"
                                   required
                                   class="w-full pl-10 pr-4 py-3 bg-gray-700 border border-gray-600 text-white rounded-2xl focus:outline-none focus:border-sky-400 transition">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-200 font-medium mb-2">Password</label>
                        <div class="relative">
                            <span class="absolute left-3 top-3.5 text-gray-400">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password"
                                   name="password"
                                   placeholder="Masukkan password"
                                   required
                                   class="w-full pl-10 pr-4 py-3 bg-gray-700 border border-gray-600 text-white rounded-2xl focus:outline-none focus:border-sky-400 transition">
                        </div>
                    </div>

                    <button type="submit"
                            class="w-full bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white font-semibold py-4 rounded-2xl transition transform hover:scale-105 active:scale-95 shadow-lg">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        LOGIN
                    </button>
                </form>

                <div class="text-center mt-6 text-gray-400 text-sm">
                    Belum punya akun? Hubungi Admin
                </div>
            </div>
        </div>
    </div>

    <!-- Script Auto Hide Alert setelah 5 detik -->
    <script>
        function autoHideAlert() {
            const errorAlert = document.getElementById('error-alert');
            const successAlert = document.getElementById('success-alert');

            if (errorAlert) {
                setTimeout(() => {
                    errorAlert.style.transition = 'all 0.5s ease';
                    errorAlert.style.opacity = '0';
                    errorAlert.style.transform = 'translateY(-10px)';
                    setTimeout(() => errorAlert.remove(), 600);
                }, 5000);
            }

            if (successAlert) {
                setTimeout(() => {
                    successAlert.style.transition = 'all 0.5s ease';
                    successAlert.style.opacity = '0';
                    successAlert.style.transform = 'translateY(-10px)';
                    setTimeout(() => successAlert.remove(), 600);
                }, 5000);
            }
        }

        window.onload = autoHideAlert;
    </script>

</body>
</html>
