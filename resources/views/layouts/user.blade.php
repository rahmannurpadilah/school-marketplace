<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - R-Store</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- TAILWIND --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- LUCIDE --}}
    <script src="https://unpkg.com/lucide@latest"></script>

    {{-- THEME VARIABLE (Light + Dark) --}}
    <style>
        :root {
            --primary: #ffffff;
            --secondary: #1B1B1B;
            --background: #f8fafc;
            --surface: #FFFFFF;
            --text-primary: #1f2937;
            --text-secondary: #2563eb;
            --accent: #F59E0B;
            --border: #e5e7eb;
        }

        @media (prefers-color-scheme: dark) {
            :root {
                --primary: #1f2937;
                --secondary: #F8F7F3;
                --background: #111827;
                --surface: #1E293B;
                --text-primary: #f9fafb;
                --text-secondary: #60a5fa;
                --accent: #FBBF24;
                --border: #374151;
            }
        }

        body {
            background-color: var(--background);
            color: var(--text-primary);
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>

    {{-- EXTEND TAILWIND --}}
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "var(--primary)",
                        secondary: "var(--secondary)",
                        background: "var(--background)",
                        surface: "var(--surface)",
                        border: "var(--border)",
                        textPrimary: "var(--text-primary)",
                        textSecondary: "var(--text-secondary)",
                        accent: "var(--accent)",
                    }
                }
            }
        }
    </script>

    {{-- CUSTOM UTILITIES --}}
    <style type="text/tailwindcss">
        @layer utilities {
            .bg-primary { background-color: var(--primary); }
            .bg-secondary { background-color: var(--secondary); }
            .bg-background { background-color: var(--background); }
            .bg-surface { background-color: var(--surface); }

            .text-primary { color: var(--text-primary); }
            .text-secondary { color: var(--text-secondary); }

            .border-primary { border-color: var(--primary); }
            .border-secondary { border-color: var(--secondary); }
            .border-accent { border-color: var(--accent); }
        }
    </style>
</head>
<body class="bg-background">

<script>
    let mobileMenuOpen = false;

    function toggleMobileMenu() {
        mobileMenuOpen = !mobileMenuOpen;
        const menu = document.getElementById('mobileMenu');

        if (mobileMenuOpen) {
            menu.classList.remove('hidden', 'opacity-0', '-translate-y-3');
            menu.classList.add('block', 'opacity-100', 'translate-y-0');
        } else {
            menu.classList.add('opacity-0', '-translate-y-3');
            setTimeout(() => {
                menu.classList.add('hidden');
                menu.classList.remove('block');
            }, 200);
        }
    }
</script>

{{-- ===========================================================
     HEADER
=========================================================== --}}
<header class="bg-gradient-to-r from-blue-600 to-blue-700 text-white fixed w-full top-0 shadow-lg z-50">
    <div class="max-w-7xl mx-auto px-6 py-4">
        <div class="flex justify-between items-center">

            {{-- LOGO --}}
            <h1 class="text-xl md:text-2xl font-bold tracking-wide">R-Store</h1>

            {{-- DESKTOP NAV --}}
            <nav class="hidden md:flex space-x-8">
                <a href="{{ route('user.dashboard') }}"
                   class="font-medium transition hover:text-blue-100 {{ request()->is('/') ? 'text-black' : 'text-white' }}">
                    Beranda
                </a>

                <a href="{{ route('produk.index') }}"
                   class="font-medium transition hover:text-blue-100 {{ request()->is('produk*') ? 'text-black' : 'text-white' }}">
                    Produk
                </a>

                <a href="{{ route('toko.index') }}"
                   class="font-medium transition hover:text-blue-100 {{ request()->is('toko*') ? 'text-black' : 'text-white' }}">
                    Toko
                </a>

                @if (Auth::user())
                    @if (Auth::user()->role == 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                        class="font-medium transition hover:text-blue-100">
                            Dashboard
                        </a>                        
                    @else
                    <a href="{{ route('member.dashboard') }}"
                       class="font-medium transition hover:text-blue-100">
                        Dashboard
                    </a>                        
                    @endif                    
                @else
                    <a href="{{ route('login') }}"
                    class="font-medium transition hover:text-blue-100">
                        Login
                    </a>
                @endif
            </nav>

            {{-- MOBILE TOGGLER --}}
            <button onclick="toggleMobileMenu()" class="md:hidden p-2 rounded-lg hover:bg-blue-500">
                <i data-lucide="menu" class="w-6 h-6 text-white"></i>
            </button>
        </div>

        {{-- MOBILE NAV --}}
        <div id="mobileMenu"
             class="hidden opacity-0 -translate-y-3 transition-all duration-300 mt-4 pb-4 md:hidden border-t border-blue-400 pt-4 space-y-4">

            <a href="{{ route('user.dashboard') }}" onclick="toggleMobileMenu()" class="block text-white hover:text-blue-100">Beranda</a>
            <a href="{{ route('produk.index') }}" onclick="toggleMobileMenu()" class="block text-white hover:text-blue-100">Produk</a>
            <a href="{{ route('toko.index') }}" onclick="toggleMobileMenu()" class="block text-white hover:text-blue-100">Toko</a>

            @guest
                <a href="{{ route('login') }}" onclick="toggleMobileMenu()" class="block text-white hover:text-blue-100">Login</a>
            @else
                <a href="{{ route('user.dashboard') }}" onclick="toggleMobileMenu()" class="block text-white hover:text-blue-100">Dashboard</a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="text-red-300 hover:text-red-100 font-medium mt-2">Logout</button>
                </form>
            @endguest

        </div>

    </div>
</header>

{{-- ===========================================================
     MAIN CONTENT
=========================================================== --}}
<main class="min-h-screen pt-28 pb-14 bg-background">
    @yield('user-content')
</main>

{{-- ===========================================================
     FOOTER
=========================================================== --}}
<footer class="bg-gradient-to-r from-blue-600 to-blue-700 text-white mt-16">
    <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-2 gap-8">

        <div>
            <h4 class="text-xl font-bold">R-Store</h4>
            <p class="text-blue-100 text-sm mt-2">Marketplace terbaik untuk kebutuhan Anda.</p>
            <p class="text-blue-100 text-sm">Tasikmalaya, Indonesia</p>
        </div>

        <div>
            <h4 class="text-xl font-bold">Navigasi Cepat</h4>
            <ul class="space-y-2 mt-2 text-blue-100">
                <li><a href="/" class="hover:text-white">Beranda</a></li>
                <li><a href="/produk" class="hover:text-white">Produk</a></li>
                <li><a href="/toko" class="hover:text-white">Toko</a></li>
                <li><a href="/login" class="hover:text-white">Login</a></li>
            </ul>
        </div>

    </div>

    <div class="border-t border-blue-400">
        <div class="max-w-7xl mx-auto px-6 py-4 text-center text-blue-100 text-sm">
            © {{ date('Y') }} R-Store. Semua Hak Dilindungi.
        </div>
    </div>
</footer>

<script>
    lucide.createIcons();
</script>

</body>
</html>
