<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark" x-data="{ darkMode: true, sidebarOpen: false }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard — AfriCode Lab')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@600;700&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
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
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
    </style>
</head>
<body class="bg-cyber-darkBg text-slate-100 font-sans antialiased min-h-screen flex flex-col">

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar Navigation -->
        <aside class="w-64 bg-slate-950 border-r border-slate-800 flex flex-col justify-between flex-shrink-0 hidden lg:flex">
            <div>
                <!-- Brand -->
                <div class="h-20 px-6 flex items-center gap-3 border-b border-slate-800">
                    <div class="w-10 h-10 rounded-xl overflow-hidden p-0.5 bg-gradient-to-r from-cyan-500 to-emerald-400">
                        <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" class="w-full h-full object-cover rounded-[10px]">
                    </div>
                    <div>
                        <span class="font-display font-bold text-lg text-white">AFRICODE</span>
                        <span class="block text-[10px] text-cyan-400 font-code font-semibold tracking-widest uppercase">Espace Apprenant</span>
                    </div>
                </div>

                <!-- Nav Menu -->
                <nav class="p-4 space-y-1.5 text-sm font-medium">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('dashboard') && !request()->routeIs('dashboard.*') ? 'bg-cyan-500/15 text-cyan-400 border border-cyan-500/30 font-bold' : 'text-slate-400 hover:text-white hover:bg-slate-900' }}">
                        <i class="fa-solid fa-gauge text-base"></i> Tableau de bord
                    </a>

                    <a href="{{ route('dashboard.courses') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('dashboard.courses') || request()->routeIs('dashboard.learn') ? 'bg-emerald-500/15 text-emerald-400 border border-emerald-500/30 font-bold' : 'text-slate-400 hover:text-white hover:bg-slate-900' }}">
                        <i class="fa-solid fa-graduation-cap text-base"></i> Mes Formations
                    </a>

                    <a href="{{ route('dashboard.projects') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('dashboard.projects') ? 'bg-purple-500/15 text-purple-400 border border-purple-500/30 font-bold' : 'text-slate-400 hover:text-white hover:bg-slate-900' }}">
                        <i class="fa-solid fa-code-fork text-base"></i> Mes Projets
                    </a>

                    <a href="{{ route('dashboard.profile') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('dashboard.profile') ? 'bg-amber-500/15 text-amber-400 border border-amber-500/30 font-bold' : 'text-slate-400 hover:text-white hover:bg-slate-900' }}">
                        <i class="fa-solid fa-user-gear text-base"></i> Mon Profil
                    </a>

                    <div class="pt-4 mt-4 border-t border-slate-800/80"></div>

                    <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-900">
                        <i class="fa-solid fa-globe"></i> Retour au site web
                    </a>
                </nav>
            </div>

            <!-- User Footer Pill -->
            <div class="p-4 border-t border-slate-800">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3 truncate">
                        <div class="w-9 h-9 rounded-full bg-cyan-500/20 border border-cyan-400 flex items-center justify-center text-cyan-400 font-bold text-xs">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                        <div class="truncate text-xs">
                            <p class="font-bold text-white truncate">{{ auth()->user()->name }}</p>
                            <p class="text-slate-400 truncate">{{ auth()->user()->email }}</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-slate-400 hover:text-rose-400 p-2" title="Déconnexion">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-y-auto">
            
            <!-- Dashboard Top Navbar -->
            <header class="h-20 bg-slate-950/80 border-b border-slate-800 px-6 flex items-center justify-between sticky top-0 z-30 backdrop-blur-md">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-lg bg-slate-900 text-slate-300">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>
                    <h1 class="text-lg font-bold font-display text-white">@yield('header_title', 'Espace Membre')</h1>
                </div>

                <div class="flex items-center gap-4">
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="px-3.5 py-1.5 rounded-xl bg-purple-600/30 border border-purple-500/50 text-purple-300 text-xs font-bold">
                            <i class="fa-solid fa-shield-halved mr-1"></i> Admin Panel
                        </a>
                    @endif

                    <div class="flex items-center gap-2 text-xs font-code text-cyan-400">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> Apprenant Actif
                    </div>
                </div>
            </header>

            <!-- Page Body -->
            <main class="p-6 sm:p-8 flex-1">
                @include('partials.alerts')
                @yield('content')
            </main>

        </div>
    </div>

</body>
</html>
