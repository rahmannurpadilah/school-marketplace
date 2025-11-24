<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - Member Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- TAILWIND --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- ICONS --}}
    <script src="https://unpkg.com/lucide@latest"></script>

    {{-- =========================
         CSS THEME VARIABLES — SAMAKAN DENGAN ADMIN
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

        /* DARK MODE — sama 100% dengan admin */
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

    {{-- ============ EXTEND TAILWIND COLORS ============ --}}
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

    {{-- CUSTOM UTILITY CLASS --}}
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
    let openSidebar = true;

    function toggleSidebar() {
        openSidebar = !openSidebar;

        const sidebar = document.getElementById('sidebar');
        const labels = document.querySelectorAll(".menu-label");

        sidebar.classList.toggle("w-[260px]");
        sidebar.classList.toggle("w-[80px]");
        labels.forEach(l => l.classList.toggle("hidden"));
    }
</script>

<div class="flex h-screen">

    {{-- ============ SIDEBAR ============ --}}
    <aside id="sidebar"
        class="hidden md:flex flex-col w-[260px] bg-primary border-r border-border transition-all duration-300">

        <div class="h-16 px-5 flex items-center justify-between border-b border-border">
            <div class="flex items-center gap-2 menu-label">
                <i data-lucide="user" class="w-6 h-6 text-primary"></i>
                <span class="font-bold text-lg text-primary">Member Panel</span>
            </div>

            <button onclick="toggleSidebar()" class="p-2">
                <i data-lucide="arrow-big-left" class="w-5 h-5 text-primary"></i>
            </button>
        </div>

        <nav class="flex-1 overflow-y-auto p-2">

            @php
                $toko = Auth::user()->Toko;
                $status = $toko ? $toko->status : null;

                // MENU DEFAULT — SELALU ADA
                $menus = [
                    ['route' => 'member.dashboard', 'icon' => 'layout-dashboard', 'label' => 'Dashboard'],
                    ['route' => 'user.dashboard', 'icon' => 'home', 'label' => 'Publik Home'],
                ];

                // JIKA TOKO ACTIVE — TAMBAHKAN MENU LAIN
                if ($status === 'active') {
                    $menus = array_merge($menus, [
                        ['route' => 'member.prodak', 'icon' => 'box', 'label' => 'Products'],
                        ['route' => 'member.kategori', 'icon' => 'layers', 'label' => 'Kategori'],
                        ['route' => 'member.gambar', 'icon' => 'image', 'label' => 'Gambar'],
                    ]);
                }
            @endphp

            @foreach($menus as $m)
                <a href="{{ route($m['route']) }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg mb-1 transition
                    {{ request()->routeIs($m['route']) 
                        ? 'bg-secondary text-background'
                        : 'hover:bg-secondary/10 text-primary'
                    }}">
                    <i data-lucide="{{ $m['icon'] }}" class="w-5 h-5"></i>
                    <span class="menu-label">{{ $m['label'] }}</span>
                </a>
            @endforeach

            <a href="{{ route('logout') }}"
                class="flex items-center gap-3 px-4 py-3 text-red-500 hover:bg-red-100 rounded-lg mt-4">
                <i data-lucide="log-out"></i>
                <span class="menu-label">Logout</span>
            </a>

        </nav>

        <div class="text-center p-4 text-xs border-t border-border menu-label text-primary/60">
            © {{ date('Y') }} Member Panel
        </div>
    </aside>

    {{-- ============ MAIN CONTENT ============ --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- TOP NAV --}}
        <header class="h-16 flex items-center justify-between px-6 border-b border-border bg-surface/80 backdrop-blur-lg">
            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()" class="p-2 md:hidden">
                    <i data-lucide="menu" class="w-6 h-6 text-primary"></i>
                </button>

                <div>
                    <h1 class="text-xl font-bold text-primary">@yield('title')</h1>
                    <p class="text-xs text-primary/60">Member Panel</p>
                </div>
            </div>

            <div class="flex gap-4">
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

<script> lucide.createIcons(); </script>

</body>
</html>
