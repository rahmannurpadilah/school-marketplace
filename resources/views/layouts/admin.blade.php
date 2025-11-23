<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- TAILWIND --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- LUCIDE --}}
    <script src="https://unpkg.com/lucide@latest"></script>

    {{-- GLOBAL COLOR THEME FROM layouts/global --}}
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
    </style>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "var(--primary)",
                        secondary: "var(--secondary)",
                        background: "var(--background)",
                        border: "var(--border)",
                        textPrimary: "var(--text-primary)",
                        textSecondary: "var(--text-secondary)",
                        accent: "var(--accent)",
                    }
                }
            }
        };
    </script>
</head>
<body class="bg-background">

<script>
    let isSidebarOpen = true;
    let isMobileSidebarOpen = false;

    function toggleSidebar() {
        isSidebarOpen = !isSidebarOpen;

        const sidebar = document.getElementById('sidebarDesktop');
        const labels = document.querySelectorAll('.menu-label');

        sidebar.classList.toggle('w-[280px]');
        sidebar.classList.toggle('w-[80px]');
        labels.forEach(l => l.classList.toggle('hidden'));
    }

    function toggleSidebarMobile() {
        isMobileSidebarOpen = !isMobileSidebarOpen;

        document.getElementById('sidebarMobile').classList.toggle('-translate-x-full');
        document.getElementById('mobileOverlay').classList.toggle('hidden');
    }
</script>

{{-- ===================== PAGE WRAPPER ===================== --}}
<div class="flex h-screen">

    {{-- ===================== DESKTOP SIDEBAR ===================== --}}
    <aside id="sidebarDesktop"
           class="hidden md:flex flex-col w-[280px] bg-primary border-r border-border transition-all duration-300">

        <div class="h-16 flex items-center justify-between px-6 border-b border-border">
            <div class="flex items-center gap-2 menu-label">
                <div class="w-8 h-8 rounded-lg bg-secondary flex items-center justify-center">
                    <i data-lucide="layout-dashboard" class="text-white w-5 h-5"></i>
                </div>
                <span class="text-lg font-bold text-textPrimary">Admin Panel</span>
            </div>

            <button onclick="toggleSidebar()" class="p-2">
                <i data-lucide="arrow-big-left" class="w-5 h-5 text-textPrimary icon-open"></i>
                <i data-lucide="arrow-big-right" class="w-5 h-5 text-textPrimary icon-close hidden"></i>
            </button>
        </div>

        <nav class="flex-1 overflow-y-auto p-2">

            {{-- DASHBOARD --}}
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg mb-1 transition
               {{ request()->routeIs('admin.dashboard') ? 'bg-secondary text-white' : 'hover:bg-secondary/10 text-textPrimary' }}">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                <span class="menu-label">Dashboard</span>
            </a>

            {{-- USERS --}}
            <a href="{{ route('admin.useradmin') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg mb-1 transition
               {{ request()->routeIs('admin.useradmin') ? 'bg-secondary text-white' : 'hover:bg-secondary/10 text-textPrimary' }}">
                <i data-lucide="users" class="w-5 h-5"></i>
                <span class="menu-label">Users</span>
            </a>

            {{-- CATEGORIES --}}
            <a href="{{ route('admin.kategori') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg mb-1 transition
               {{ request()->routeIs('admin.kategori') ? 'bg-secondary text-white' : 'hover:bg-secondary/10 text-textPrimary' }}">
                <i data-lucide="layers" class="w-5 h-5"></i>
                <span class="menu-label">Categories</span>
            </a>

            {{-- PRODUCTS --}}
            <a href="{{ route('admin.produk') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg mb-1 transition
               {{ request()->routeIs('admin.produk') ? 'bg-secondary text-white' : 'hover:bg-secondary/10 text-textPrimary' }}">
                <i data-lucide="package" class="w-5 h-5"></i>
                <span class="menu-label">Products</span>
            </a>

            {{-- TOKO --}}
            <a href="{{ route('admin.toko.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg mb-1 transition
               {{ request()->routeIs('admin.toko.index') ? 'bg-secondary text-white' : 'hover:bg-secondary/10 text-textPrimary' }}">
                <i data-lucide="store" class="w-5 h-5"></i>
                <span class="menu-label">Toko</span>
            </a>

            {{-- LOGOUT --}}
            <a href="{{ route('logout') }}"
               class="flex items-center gap-3 px-4 py-3 text-red-500 mt-4 hover:bg-red-100 rounded-lg">
                <i data-lucide="log-out" class="w-5 h-5"></i>
                <span class="menu-label">Logout</span>
            </a>

        </nav>

        <div class="p-4 text-center text-textPrimary/60 text-xs border-t border-border menu-label">
            © {{ date('Y') }} Admin Panel
        </div>
    </aside>

    {{-- ===================== MOBILE OVERLAY ===================== --}}
    <div id="mobileOverlay" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm z-40 md:hidden"
         onclick="toggleSidebarMobile()"></div>

    {{-- ===================== MOBILE SIDEBAR ===================== --}}
    <aside id="sidebarMobile"
           class="md:hidden fixed top-0 left-0 w-[280px] h-full bg-primary border-r border-border -translate-x-full z-50 transition">

        <div class="h-16 px-6 flex items-center justify-between border-b border-border">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-secondary flex items-center justify-center">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 text-white"></i>
                </div>
                <span class="font-bold text-lg">Admin Panel</span>
            </div>

            <button onclick="toggleSidebarMobile()" class="p-2">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>

        <nav class="p-4">

            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg mb-1
                {{ request()->routeIs('admin.dashboard') ? 'bg-secondary text-white' : 'hover:bg-secondary/10' }}">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                Dashboard
            </a>

            <a href="{{ route('admin.useradmin') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg mb-1
                {{ request()->routeIs('admin.useradmin') ? 'bg-secondary text-white' : 'hover:bg-secondary/10' }}">
                <i data-lucide="users" class="w-5 h-5"></i>
                Users
            </a>

            <a href="{{ route('admin.kategori') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg mb-1
                {{ request()->routeIs('admin.kategori') ? 'bg-secondary text-white' : 'hover:bg-secondary/10' }}">
                <i data-lucide="layers" class="w-5 h-5"></i>
                Categories
            </a>

            <a href="{{ route('admin.produk') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg mb-1
                {{ request()->routeIs('admin.produk') ? 'bg-secondary text-white' : 'hover:bg-secondary/10' }}">
                <i data-lucide="package" class="w-5 h-5"></i>
                Products
            </a>

            <a href="{{ route('logout') }}" class="flex items-center gap-3 px-4 py-3 text-red-500 mt-3 rounded-lg hover:bg-red-100">
                <i data-lucide="log-out" class="w-5 h-5"></i>
                Logout
            </a>

        </nav>
    </aside>

    {{-- ===================== MAIN CONTENT ===================== --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- TOP BAR --}}
        <header class="h-16 px-6 flex items-center justify-between border-b border-border bg-background/70 backdrop-blur">
            <div class="flex items-center gap-3">
                <button class="md:hidden p-2 rounded-lg hover:bg-primary" onclick="toggleSidebarMobile()">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
                <div>
                    <h1 class="text-xl font-bold">@yield('title')</h1>
                    <p class="text-xs text-textPrimary/60">Manage your application</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <i data-lucide="bell" class="w-5 h-5"></i>
                <i data-lucide="user" class="w-5 h-5"></i>
            </div>
        </header>

        {{-- PAGE CONTENT --}}
        <main class="flex-1 overflow-y-auto p-6">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>

    </div>

</div>

<script>
    lucide.createIcons();
</script>

</body>
</html>
