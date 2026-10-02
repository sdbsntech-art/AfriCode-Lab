<nav x-data="{ mobileMenuOpen: false }" class="sticky top-0 z-50 border-b border-[#e5e1d6] bg-[#f6f3eb]/95 shadow-sm backdrop-blur-xl">
    <div class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-12">
        <div class="flex h-[76px] items-center justify-between gap-4">
            <a href="{{ route('home') }}" class="flex shrink-0 items-center gap-3" aria-label="AfriCode Lab, accueil">
                <img src="{{ asset('images/logo.jpeg') }}" alt="" class="h-11 w-11 rounded-xl object-cover">
                <span class="flex flex-col">
                    <span class="font-display text-base font-bold tracking-wide text-[#18382b]">AFRICODE <span class="text-[#b85e32]">LAB</span></span>
                    <span class="text-[9px] font-semibold uppercase tracking-[0.17em] text-[#647167]">Le numérique africain en mouvement</span>
                </span>
            </a>

            <div class="hidden items-center gap-1 lg:flex">
                <a href="{{ route('home') }}" class="rounded-full px-3 py-2 text-sm font-semibold transition hover:bg-white hover:text-[#b85e32] {{ request()->routeIs('home') ? 'text-[#b85e32]' : 'text-[#526258]' }}">Accueil</a>
                <a href="{{ route('about') }}" class="rounded-full px-3 py-2 text-sm font-semibold transition hover:bg-white hover:text-[#b85e32] {{ request()->routeIs('about') ? 'text-[#b85e32]' : 'text-[#526258]' }}">Notre vision</a>
                <a href="{{ route('home') }}#programme" class="rounded-full px-3 py-2 text-sm font-semibold text-[#526258] transition hover:bg-white hover:text-[#b85e32]">Programme</a>
                <a href="{{ route('projects') }}" class="rounded-full px-3 py-2 text-sm font-semibold transition hover:bg-white hover:text-[#b85e32] {{ request()->routeIs('projects') ? 'text-[#b85e32]' : 'text-[#526258]' }}">Projets</a>
                <a href="{{ route('community') }}" class="rounded-full px-3 py-2 text-sm font-semibold transition hover:bg-white hover:text-[#b85e32] {{ request()->routeIs('community') ? 'text-[#b85e32]' : 'text-[#526258]' }}">Communauté</a>
            </div>

            <div class="hidden items-center gap-3 lg:flex">
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="rounded-full px-3 py-2 text-sm font-semibold text-[#526258] transition hover:bg-white">Administration</a>
                    @endif
                    <a href="{{ route('dashboard') }}" class="rounded-full px-3 py-2 text-sm font-semibold text-[#526258] transition hover:bg-white">Mon espace</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="px-2 py-2 text-sm font-semibold text-[#647167] transition hover:text-[#b85e32]">Déconnexion</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-3 py-2 text-sm font-semibold text-[#526258] transition hover:text-[#1d4935]">Connexion</a>
                @endauth
                <a href="{{ route('membership.create') }}" class="inline-flex items-center gap-2 rounded-full bg-[#1d4935] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#143a29]">
                    <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                    Adhérer
                </a>
            </div>

            <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="flex h-11 w-11 items-center justify-center rounded-xl border border-[#d9ded5] bg-white text-[#1d4935] lg:hidden" :aria-expanded="mobileMenuOpen.toString()" aria-label="Ouvrir le menu">
                <i class="fa-solid" :class="mobileMenuOpen ? 'fa-xmark' : 'fa-bars'" aria-hidden="true"></i>
            </button>
        </div>
    </div>

    <div x-show="mobileMenuOpen" x-cloak @keydown.escape.window="mobileMenuOpen = false" class="border-t border-[#e5e1d6] bg-[#f6f3eb] px-5 pb-5 pt-3 lg:hidden">
        <div class="mx-auto flex max-w-7xl flex-col gap-1">
            <a @click="mobileMenuOpen = false" href="{{ route('home') }}" class="rounded-xl px-4 py-3 text-sm font-semibold text-[#274535] hover:bg-white">Accueil</a>
            <a @click="mobileMenuOpen = false" href="{{ route('about') }}" class="rounded-xl px-4 py-3 text-sm font-semibold text-[#274535] hover:bg-white">Notre vision</a>
            <a @click="mobileMenuOpen = false" href="{{ route('home') }}#programme" class="rounded-xl px-4 py-3 text-sm font-semibold text-[#274535] hover:bg-white">Programme</a>
            <a @click="mobileMenuOpen = false" href="{{ route('projects') }}" class="rounded-xl px-4 py-3 text-sm font-semibold text-[#274535] hover:bg-white">Projets</a>
            <a @click="mobileMenuOpen = false" href="{{ route('community') }}" class="rounded-xl px-4 py-3 text-sm font-semibold text-[#274535] hover:bg-white">Communauté</a>
            <a @click="mobileMenuOpen = false" href="{{ route('contact') }}" class="rounded-xl px-4 py-3 text-sm font-semibold text-[#274535] hover:bg-white">Contact</a>
            @auth
                <a href="{{ route('dashboard') }}" class="mt-2 rounded-xl border border-[#d9ded5] bg-white px-4 py-3 text-center text-sm font-semibold text-[#274535]">Mon espace</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="mt-2 w-full rounded-xl border border-[#d9ded5] px-4 py-3 text-sm font-semibold text-[#647167]">Déconnexion</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="mt-2 rounded-xl border border-[#d9ded5] bg-white px-4 py-3 text-center text-sm font-semibold text-[#274535]">Connexion</a>
            @endauth
            <a href="{{ route('membership.create') }}" class="mt-2 rounded-xl bg-[#1d4935] px-4 py-3 text-center text-sm font-bold text-white">Adhérer à AfriCode Lab</a>
            <a href="{{ route('contribute') }}" class="rounded-xl px-4 py-3 text-center text-sm font-semibold text-[#274535] hover:bg-white">Proposer une contribution</a>
        </div>
    </div>
</nav>
