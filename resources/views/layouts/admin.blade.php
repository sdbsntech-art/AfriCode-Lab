<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ sidebarOpen: false }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Administration — AfriCode Lab')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        display: ['"Space Grotesk"', 'sans-serif'],
                        code: ['"Fira Code"', 'monospace'],
                    },
                },
            },
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        .glass-card {
            background: #fff;
            border: 1px solid #e3e4dc;
            box-shadow: 0 12px 30px rgba(24, 56, 43, 0.06);
        }
        .legacy-admin-content [class~="text-white"],
        .legacy-admin-content [class~="text-slate-100"],
        .legacy-admin-content [class~="text-slate-200"] {
            color: #18382b !important;
        }
        .legacy-admin-content [class~="text-slate-300"],
        .legacy-admin-content [class~="text-slate-400"] {
            color: #526258 !important;
        }
        .legacy-admin-content [class~="text-cyan-300"],
        .legacy-admin-content [class~="text-cyan-400"],
        .legacy-admin-content [class~="text-emerald-300"],
        .legacy-admin-content [class~="text-emerald-400"],
        .legacy-admin-content [class~="text-teal-300"],
        .legacy-admin-content [class~="text-teal-400"] {
            color: #1d4935 !important;
        }
        .legacy-admin-content [class~="text-rose-300"],
        .legacy-admin-content [class~="text-rose-400"] {
            color: #a44735 !important;
        }
        .legacy-admin-content [class~="text-amber-300"],
        .legacy-admin-content [class~="text-amber-400"] {
            color: #8a5b2c !important;
        }
        .legacy-admin-content [class~="text-purple-300"],
        .legacy-admin-content [class~="text-purple-400"] {
            color: #70468c !important;
        }
        .legacy-admin-content [class*="bg-slate-950"],
        .legacy-admin-content [class*="bg-slate-900"],
        .legacy-admin-content [class*="bg-slate-800"] {
            background-color: #f8f7f1 !important;
        }
        .legacy-admin-content [class*="border-slate-"] {
            border-color: #e3e4dc !important;
        }
        .legacy-admin-content [class*="divide-slate-"] > :not(:last-child) {
            border-color: #edf0e9 !important;
        }
        .legacy-admin-content [class*="hover:bg-slate-"]:hover {
            background-color: #eef2ea !important;
        }
    </style>
</head>
<body class="min-h-screen bg-[#f6f3eb] font-sans text-[#18382b] antialiased selection:bg-[#d87842]/20 selection:text-[#18382b]">
    <div x-cloak x-show="sidebarOpen" class="fixed inset-0 z-30 bg-[#18382b]/40 lg:hidden" @click="sidebarOpen = false"></div>

    <div class="relative flex min-h-screen">
        <aside
            class="fixed inset-y-0 left-0 z-40 flex w-72 -translate-x-full flex-col border-r border-white/10 bg-[#18382b] text-white transition-transform duration-200 lg:sticky lg:top-0 lg:h-screen lg:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        >
            <div class="flex h-24 items-center justify-between gap-3 border-b border-white/10 px-6">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="AfriCode Lab" class="h-11 w-11 rounded-2xl object-cover">
                    <span>
                        <span class="block font-display text-lg font-bold tracking-tight">AFRICODE LAB</span>
                        <span class="mt-0.5 block text-[10px] font-semibold uppercase tracking-[0.2em] text-[#d9c8a5]">Administration</span>
                    </span>
                </a>
                <button type="button" class="rounded-lg p-2 text-white/70 hover:bg-white/10 lg:hidden" @click="sidebarOpen = false" aria-label="Fermer le menu">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <nav class="flex-1 space-y-1 overflow-y-auto px-4 py-6 text-sm">
                <p class="px-3 pb-2 text-[10px] font-bold uppercase tracking-[0.18em] text-white/45">Pilotage</p>
                <a href="{{ route('admin.dashboard') }}" @click="sidebarOpen = false" class="flex items-center gap-3 rounded-xl px-3 py-3 transition {{ request()->routeIs('admin.dashboard') ? 'bg-[#f6f3eb] font-bold text-[#18382b]' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">
                    <i class="fa-solid fa-chart-pie w-5 text-center"></i>
                    <span>Vue d’ensemble</span>
                </a>
                <a href="{{ route('admin.memberships') }}" @click="sidebarOpen = false" class="flex items-center justify-between gap-3 rounded-xl px-3 py-3 transition {{ request()->routeIs('admin.memberships*') ? 'bg-[#f6f3eb] font-bold text-[#18382b]' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">
                    <span class="flex items-center gap-3">
                        <i class="fa-solid fa-people-group w-5 text-center"></i>
                        <span>Demandes d’adhésion</span>
                    </span>
                    @if($pendingMembershipsCount > 0)
                        <span class="rounded-full bg-[#d87842] px-2 py-0.5 text-xs font-bold text-white">{{ $pendingMembershipsCount }}</span>
                    @endif
                </a>
                <a href="{{ route('admin.users') }}" @click="sidebarOpen = false" class="flex items-center gap-3 rounded-xl px-3 py-3 transition {{ request()->routeIs('admin.users') ? 'bg-white/10 font-semibold text-white' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">
                    <i class="fa-solid fa-users w-5 text-center"></i>
                    <span>Utilisateurs</span>
                </a>
                <a href="{{ route('admin.applications') }}" @click="sidebarOpen = false" class="flex items-center gap-3 rounded-xl px-3 py-3 transition {{ request()->routeIs('admin.applications') ? 'bg-white/10 font-semibold text-white' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">
                    <i class="fa-solid fa-file-signature w-5 text-center"></i>
                    <span>Candidatures</span>
                </a>

                <p class="px-3 pb-2 pt-7 text-[10px] font-bold uppercase tracking-[0.18em] text-white/45">Activités</p>
                <a href="{{ route('admin.projects') }}" @click="sidebarOpen = false" class="flex items-center gap-3 rounded-xl px-3 py-3 transition {{ request()->routeIs('admin.projects') ? 'bg-white/10 font-semibold text-white' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">
                    <i class="fa-solid fa-lightbulb w-5 text-center"></i>
                    <span>Projets</span>
                </a>
                <a href="{{ route('admin.events') }}" @click="sidebarOpen = false" class="flex items-center gap-3 rounded-xl px-3 py-3 transition {{ request()->routeIs('admin.events') ? 'bg-white/10 font-semibold text-white' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">
                    <i class="fa-solid fa-calendar-days w-5 text-center"></i>
                    <span>Agenda</span>
                </a>
                <a href="{{ route('admin.formations') }}" @click="sidebarOpen = false" class="flex items-center gap-3 rounded-xl px-3 py-3 transition {{ request()->routeIs('admin.formations') ? 'bg-white/10 font-semibold text-white' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">
                    <i class="fa-solid fa-book-open w-5 text-center"></i>
                    <span>Ressources</span>
                </a>
                <a href="{{ route('admin.testimonials') }}" @click="sidebarOpen = false" class="flex items-center gap-3 rounded-xl px-3 py-3 transition {{ request()->routeIs('admin.testimonials') ? 'bg-white/10 font-semibold text-white' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">
                    <i class="fa-solid fa-quote-left w-5 text-center"></i>
                    <span>Témoignages</span>
                </a>

                <div class="my-5 border-t border-white/10"></div>
                <a href="{{ route('home') }}" class="flex items-center gap-3 rounded-xl px-3 py-3 text-white/75 transition hover:bg-white/10 hover:text-white">
                    <i class="fa-solid fa-arrow-up-right-from-square w-5 text-center"></i>
                    <span>Voir le site public</span>
                </a>
            </nav>

            <div class="border-t border-white/10 p-4">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#d87842] font-bold text-white">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}
                    </span>
                    <span class="min-w-0 flex-1">
                        <span class="block truncate text-sm font-semibold">{{ auth()->user()->name ?? 'Administrateur' }}</span>
                        <span class="block truncate text-xs text-white/55">{{ auth()->user()->email ?? '' }}</span>
                    </span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" title="Se déconnecter" class="rounded-lg p-2 text-white/65 transition hover:bg-white/10 hover:text-white">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <div class="flex min-w-0 flex-1 flex-col">
            <header class="sticky top-0 z-20 flex min-h-20 items-center justify-between gap-4 border-b border-[#dfe3d8] bg-[#f6f3eb]/95 px-4 backdrop-blur sm:px-8">
                <div class="flex items-center gap-3">
                    <button type="button" class="rounded-xl border border-[#d9ded5] bg-white p-2.5 text-[#1d4935] lg:hidden" @click="sidebarOpen = true" aria-label="Ouvrir le menu">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-[#8a9589]">AfriCode Lab</p>
                        <h1 class="font-display text-base font-bold text-[#18382b] sm:text-lg">@yield('header_title', 'Vue d’ensemble')</h1>
                    </div>
                </div>
                <span class="hidden items-center gap-2 rounded-full border border-[#d9ded5] bg-white px-3 py-2 text-xs font-semibold text-[#526258] sm:inline-flex">
                    <i class="fa-solid fa-database text-[#b85e32]"></i>
                    {{ strtoupper(config('database.default')) }} · {{ config('database.connections.'.config('database.default').'.database') }}
                </span>
            </header>

            <main class="w-full flex-1 px-4 py-6 sm:px-8 sm:py-8">
                <div class="mx-auto max-w-7xl">
                    @include('partials.alerts')
                    <div class="{{ request()->routeIs('admin.dashboard', 'admin.memberships') ? '' : 'legacy-admin-content' }}">
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
