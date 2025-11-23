<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- TAILWIND CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- LUCIDE ICON CDN --}}
    <script src="https://unpkg.com/lucide@latest"></script>

    {{-- CUSTOM CSS + TAILWIND UTILITIES --}}
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
            background: var(--background);
            color: var(--text-primary);
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>

    {{-- EXTEND TAILWIND WITH CUSTOM COLORS --}}
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

    {{-- CUSTOM TAILWIND UTILITY CLASSES --}}
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

    <title>@yield('title', 'My App')</title>
</head>
<body class="min-h-screen">
    
    {{-- PAGE CONTENT --}}
    @yield('content')

    {{-- RUN LUCIDE --}}
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
