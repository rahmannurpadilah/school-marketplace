@extends('layouts.global')

@section('title', $title ?? 'User Page')

@section('content')

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

{{-- HEADER --}}
<header class="bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg fixed w-full top-0 z-50
        transition-all duration-700 ease-out animate-[fadeIn_0.6s_ease-out]">
    <div class="max-w-7xl mx-auto px-6 py-4">
        <div class="flex justify-between items-center">

            {{-- LOGO --}}
            <div class="flex items-center">
                <h1 class="text-xl md:text-2xl font-bold tracking-wide animate-[fadeIn_1s_ease-out]">
                    R-Store
                </h1>
            </div>

            {{-- DESKTOP NAV --}}
            <nav class="hidden md:flex space-x-8 animate-[fadeIn_0.8s_ease-out]">
                <a href="{{ route('user.dashboard') }}"
                   class="font-medium transition duration-300 ease-in-out hover:text-blue-100 {{ request()->is('/') ? 'text-black' : 'text-white' }}">
                    Beranda
                </a>

                <a href="{{ route('produk.index') }}"
                   class="font-medium transition duration-300 ease-in-out hover:text-blue-100 {{ request()->is('produk*') ? 'text-black' : 'text-white' }}">
                    Produk
                </a>

                <a href="{{ route('toko.index') }}"
                   class="font-medium transition duration-300 ease-in-out hover:text-blue-100 {{ request()->is('toko*') ? 'text-black' : 'text-white' }}">
                    Toko
                </a>

                @guest
                    <a href="{{ route('login') }}"
                       class="font-medium transition duration-300 hover:text-blue-100 {{ request()->is('login') ? 'text-black' : 'text-white' }}">
                        Login
                    </a>
                @else
                    <a href="{{ route('dashboard.user') }}"
                       class="font-medium transition duration-300 hover:text-blue-100">
                       Dashboard
                    </a>
                @endguest
            </nav>

            {{-- MOBILE BUTTON --}}
            <button onclick="toggleMobileMenu()"
                class="md:hidden p-2 rounded-lg hover:bg-blue-500 transition-colors duration-300">
                <i data-lucide="menu" class="w-6 h-6 text-white"></i>
            </button>
        </div>

        {{-- MOBILE NAV --}}
        <div id="mobileMenu"
            class="hidden opacity-0 -translate-y-3 transition-all duration-300 md:hidden mt-4 pb-4 
                   border-t border-blue-500 pt-4 space-y-4">

            <a href="{{ route('user.dashboard') }}"
               onclick="toggleMobileMenu()"
               class="block text-white font-medium hover:text-blue-100 transition duration-300">
               Beranda
            </a>

            <a href="{{ route('produk.index') }}"
               onclick="toggleMobileMenu()"
               class="block text-white font-medium hover:text-blue-100 transition duration-300">
               Produk
            </a>

            <a href="{{ route('toko.index') }}"
               onclick="toggleMobileMenu()"
               class="block text-white font-medium hover:text-blue-100 transition duration-300">
               Toko
            </a>

            @guest
                <a href="{{ route('login') }}"
                   onclick="toggleMobileMenu()"
                   class="block text-white font-medium hover:text-blue-100 transition duration-300">
                   Login
                </a>
            @else
                <a href="{{ route('dashboard.user') }}"
                   onclick="toggleMobileMenu()"
                   class="block text-white font-medium hover:text-blue-100 transition duration-300">
                   Dashboard
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="text-red-300 hover:text-red-100 font-medium mt-2 transition duration-300">
                        Logout
                    </button>
                </form>
            @endguest
        </div>
    </div>
</header>

{{-- MAIN CONTENT --}}
<main class="bg-blue-50 min-h-screen pt-28 pb-12 animate-[fadeUp_0.6s_ease-out]">
    @yield('user-content')
</main>

{{-- FOOTER --}}
<footer class="bg-gradient-to-r from-blue-600 to-blue-700 text-white mt-16 animate-[fadeIn_0.8s_ease-out]">
    <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-2 gap-8">

        {{-- INFO --}}
        <div class="space-y-4">
            <h4 class="text-xl font-bold">R-store</h4>
            <div class="space-y-2 text-blue-100">
                <p class="text-sm">Marketplace terbaik untuk kebutuhan Anda.</p>
                <p class="text-sm">Tasikmalaya, Indonesia</p>
            </div>
        </div>

        {{-- NAVIGATION --}}
        <div class="space-y-4">
            <h4 class="text-xl font-bold">Navigasi Cepat</h4>
            <ul class="space-y-2 text-blue-100">
                <li><a href="/" class="hover:text-white transition duration-300">Beranda</a></li>
                <li><a href="/produk" class="hover:text-white transition duration-300">Produk</a></li>
                <li><a href="/toko" class="hover:text-white transition duration-300">Toko</a></li>
                <li><a href="/login" class="hover:text-white transition duration-300">Login</a></li>
            </ul>
        </div>

    </div>

    {{-- SUB FOOTER --}}
    <div class="border-t border-blue-500">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="text-center text-blue-100 text-sm">
                © {{ date('Y') }} R-store. Semua Hak Dilindungi.
            </div>
        </div>
    </div>
</footer>

<script>
    lucide.createIcons();
</script>

@endsection
