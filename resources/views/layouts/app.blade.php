<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'AfriCode Lab — Construisons le numérique africain')</title>
    <meta name="description" content="@yield('meta_description', 'AfriCode Lab fédère les talents et les professionnels pour faire émerger des solutions numériques utiles à l’Afrique.')">
    <link rel="icon" href="{{ asset('images/logo.jpeg') }}" type="image/jpeg">

    <!-- Open Graph SEO -->
    <meta property="og:title" content="@yield('title', 'AfriCode Lab — Construisons le numérique africain')">
    <meta property="og:description" content="Une initiative panafricaine pour fédérer les talents et construire des solutions numériques utiles au continent.">
    <meta property="og:image" content="{{ asset('images/logo.jpeg') }}">
    <meta property="og:type" content="website">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&family=Space+Grotesk:wght@500;700&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            400: '#38bdf8',
                            500: '#0284c7',
                            600: '#0284c7',
                            700: '#0369a1',
                            900: '#0c4a6e',
                        },
                        cyber: {
                            green: '#00F5A0',
                            cyan: '#00F2FE',
                            gold: '#FFD700',
                            purple: '#6C5CE7',
                            darkBg: '#080C16',
                            cardBg: '#0F172A',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        display: ['"Space Grotesk"', 'sans-serif'],
                        code: ['"Fira Code"', 'monospace'],
                    },
                    boxShadow: {
                        neon: '0 0 20px rgba(0, 242, 254, 0.35)',
                        neonGreen: '0 0 20px rgba(0, 245, 160, 0.35)',
                        glass: '0 8px 32px 0 rgba(0, 0, 0, 0.37)',
                    }
                }
            }
        }
    </script>

    <!-- FontAwesome & Alpine.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        .glass-panel {
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .text-gradient {
            background: linear-gradient(135deg, #00F2FE 0%, #4FACFE 50%, #00F5A0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .text-gradient-gold {
            background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .glow-border {
            position: relative;
        }
        .glow-border::after {
            content: '';
            position: absolute;
            inset: -1px;
            background: linear-gradient(90deg, #00F2FE, #6C5CE7, #00F5A0);
            border-radius: inherit;
            z-index: -1;
            opacity: 0.4;
            transition: opacity 0.3s ease;
        }
        .glow-border:hover::after {
            opacity: 0.9;
        }
        /* Grid background effect */
        .bg-grid-pattern {
            background-size: 40px 40px;
            background-image: 
                linear-gradient(to right, rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
        }
    </style>
    @yield('styles')
</head>
<body class="{{ request()->routeIs('home', 'about', 'community', 'contribute', 'login', 'projects') ? 'bg-[#f6f3eb] text-[#18382b]' : 'bg-cyber-darkBg text-slate-100' }} min-h-screen flex flex-col font-sans antialiased selection:bg-[#e9a15b] selection:text-[#18382b]">

    <!-- Header Navigation -->
    @include('partials.navbar')

    <!-- Flash Messages -->
    <main class="flex-grow">
        @include('partials.alerts')
        @yield('content')
    </main>

    <!-- Footer -->
    @include('partials.footer')

    @yield('scripts')
</body>
</html>
