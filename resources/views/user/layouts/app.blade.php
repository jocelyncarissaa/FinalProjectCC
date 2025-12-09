<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PharmaPlus</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        // Warna Latar Belakang Biru Muda untuk Hero Section
                        'hero-bg': '#DEE9FF', 
                        'main-blue': '#4F46E5',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
</head>

<body class="font-sans bg-white min-h-screen">
    {{-- LOGIKA UTAMA UNTUK MEMILIH HEADER BERDASARKAN STATUS LOGIN --}}
    @auth
        {{-- Jika user login, tampilkan header authenticated --}}
        @include('user.layouts.header_auth') 
    @else
        {{-- Jika user belum login, tampilkan header public/guest --}}
        @include('user.layouts.header') 
    @endauth

    <main>
        @yield('content')
    </main>

    @include('user.layouts.footer')
</body>
</html>