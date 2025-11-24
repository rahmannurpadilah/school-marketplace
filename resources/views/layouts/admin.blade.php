<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- TAILWINd --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- LUCIDE --}}
    <script src="https://unpkg.com/lucide@latest"></script>

    {{-- =========================
         CSS THEME VARIABLES
       ========================= --}}
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

        /* DARK MODE */
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
            background: var(--background);
            color: var(--text-primary);
        }
    </style>

    {{-- =========================
         EXTEND TAILWIND COLORS
       ========================= --}}
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "var(--primary)",
                        secondary: "var(--secondary)",
                        background: "var(--background)",
                        surface: "var(--surface)",
                        textPrimary: "var(--text-primary)",
                        textSecondary: "var(--text-secondary)",
                        accent: "var(--accent)",
                        border: "var(--border)",
                    }
                }
            }
        }
    </script>

    {{-- =========================
         CUSTOM UTILITY CLASSES
       ========================= --}}
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

    {{-- ===================== SIDEBAR (DESKTOP) ===================== --}}
    <aside 
        id="sidebarDesktop"
        class="hidden md:flex flex-col w-[280px] bg-primary border-r border-border transition-all duration-300">

        <div class="h-16 flex items-center justify-between px-6 border-b border-border">
            <div class="flex items-center gap-2 menu-label">
                <div class="w-8 h-8 rounded-lg bg-secondary flex items-center justify-center">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 text-background"></i>
                </div>
                <span class="text-lg font-bold text-primary">Admin Panel</span>
            </div>

            <button onclick="toggleSidebar()" class="p-2">
                <i data-lucide="arrow-big-left" class="w-5 h-5 text-primary"></i>
            </button>
        </div>

        <nav class="flex-1 overflow-y-auto p-2">

            {{-- ========== MENU ========== --}}
            @php
                $menus = [
                    ['route' => 'admin.dashboard', 'icon' => 'layout-dashboard', 'label' => 'Dashboard'],
                    ['route' => 'admin.useradmin', 'icon' => 'users', 'label' => 'Users'],
                    ['route' => 'admin.kategori', 'icon' => 'layers', 'label' => 'Categories'],
                    ['route' => 'admin.produk', 'icon' => 'package', 'label' => 'Products'],
                    ['route' => 'admin.toko.index', 'icon' => 'store', 'label' => 'Toko'],
                ];
            @endphp

            @foreach($menus as $m)
                <a href="{{ route($m['route']) }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg mb-1 transition
                    {{ request()->routeIs($m['route']) ? 'bg-secondary text-background' : 'hover:bg-secondary/10 text-primary' }}">
                    <i data-lucide="{{ $m['icon'] }}" class="w-5 h-5"></i>
                    <span class="menu-label">{{ $m['label'] }}</span>
                </a>
            @endforeach

            {{-- LOGOUT --}}
            <a href="{{ route('logout') }}"
                class="flex items-center gap-3 px-4 py-3 text-red-500 mt-4 hover:bg-red-100 rounded-lg">
                <i data-lucide="log-out" class="w-5 h-5"></i>
                <span class="menu-label">Logout</span>
            </a>

        </nav>

        <div class="p-4 text-center text-primary/60 text-xs border-t border-border menu-label">
            © {{ date('Y') }} Admin Panel
        </div>
    </aside>

    {{-- ===================== MOBILE OVERLAY ===================== --}}
    <div id="mobileOverlay" class="hidden fixed inset-0 bg-black/50 backdrop-blur-md z-40 md:hidden"
         onclick="toggleSidebarMobile()"></div>

    {{-- ===================== MOBILE SIDEBAR ===================== --}}
    <aside 
        id="sidebarMobile"
        class="md:hidden fixed top-0 left-0 w-[280px] h-full bg-primary border-r border-border -translate-x-full transition z-50">

        <div class="h-16 px-6 flex items-center justify-between border-b border-border">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-secondary flex items-center justify-center">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 text-primary"></i>
                </div>
                <span class="text-lg font-bold text-primary">Admin Panel</span>
            </div>

            <button onclick="toggleSidebarMobile()" class="p-2">
                <i data-lucide="x" class="w-6 h-6 text-primary"></i>
            </button>
        </div>

        <nav class="p-4">
            @foreach($menus as $m)
                <a href="{{ route($m['route']) }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg mb-1 transition
                    {{ request()->routeIs($m['route']) ? 'bg-secondary text-primary' : 'hover:bg-secondary/10 text-primary' }}">
                    <i data-lucide="{{ $m['icon'] }}" class="w-5 h-5"></i>
                    {{ $m['label'] }}
                </a>
            @endforeach
        </nav>

    </aside>

    {{-- ===================== MAIN CONTENT ===================== --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- TOP BAR --}}
        <header class="h-16 px-6 flex items-center justify-between border-b border-border bg-surface/80 backdrop-blur-lg">
            <div class="flex items-center gap-3">
                <button class="md:hidden p-2 rounded-lg hover:bg-primary" onclick="toggleSidebarMobile()">
                    <i data-lucide="menu" class="w-6 h-6 text-primary"></i>
                </button>
                <div>
                    <h1 class="text-xl font-bold text-primary">@yield('title')</h1>
                    <p class="text-xs text-primary/60">Manage your application</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <i data-lucide="bell" class="w-5 h-5 text-primary"></i>
                <i data-lucide="user" class="w-5 h-5 text-primary"></i>
            </div>
        </header>

        {{-- CONTENT --}}
        <main class="flex-1 overflow-y-auto p-6 bg-background">
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
