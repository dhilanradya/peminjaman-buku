<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .content-wrapper {
            margin-left: 256px;   /* Lebar sidebar */
        }
    </style>
</head>
<body class="bg-gray-900">

    <!-- Header -->
    @include('components.header')

    <!-- Sidebar -->
    @include('components.sidebar')

    <!-- Main Content -->
    <div class="content-wrapper">
        <main class="min-h-screen p-6">
            @yield('content')
        </main>

        <!-- Footer -->
        @include('components.footer')
    </div>

</body>
</html>
