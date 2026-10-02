@extends('layouts.app')

@section('title', 'Connexion — AfriCode Lab')
@section('meta_description', 'Connectez-vous à votre espace AfriCode Lab pour retrouver votre communauté et participer aux initiatives numériques africaines.')

@section('content')
<section class="relative isolate overflow-hidden bg-[#f6f3eb]">
    <div class="pointer-events-none absolute -left-40 top-12 h-80 w-80 rounded-full bg-[#d87842]/10 blur-3xl" aria-hidden="true"></div>
    <div class="pointer-events-none absolute -right-40 bottom-0 h-96 w-96 rounded-full bg-[#1d4935]/10 blur-3xl" aria-hidden="true"></div>

    <div class="relative mx-auto grid min-h-[calc(100vh-13rem)] max-w-7xl items-center gap-10 px-5 py-10 sm:px-8 sm:py-14 lg:grid-cols-[minmax(0,0.95fr)_minmax(0,1.05fr)] lg:gap-16 lg:px-12">
        <div class="order-1 mx-auto w-full max-w-xl">
            <div class="rounded-[2rem] border border-[#e5e1d6] bg-white p-6 shadow-xl shadow-[#18382b]/[0.06] sm:p-9 lg:p-10">
                <div class="space-y-7">
                    <div class="space-y-4">
                        <span class="inline-flex items-center gap-2 rounded-full border border-[#d9dfcf] bg-[#f8f7f1] px-3.5 py-2 text-xs font-bold uppercase tracking-[0.14em] text-[#315b43]">
                            <span class="h-2 w-2 rounded-full bg-[#d87842]"></span>
                            Espace membre
                        </span>
                        <div>
                            <h1 class="font-display text-3xl font-bold tracking-tight text-[#18382b] sm:text-4xl">Heureux de vous revoir.</h1>
                            <p class="mt-3 max-w-md text-sm leading-6 text-[#647167] sm:text-base">
                                Connectez-vous pour retrouver votre espace et prendre part aux initiatives d’AfriCode Lab.
                            </p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="space-y-5" x-data="{ showPassword: false }">
                        @csrf

                        <div>
                            <label for="email" class="mb-2 block text-sm font-semibold text-[#274535]">Adresse e-mail</label>
                            <div class="relative">
                                <i class="fa-regular fa-envelope pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-[#8a9589]" aria-hidden="true"></i>
                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus
                                    autocomplete="username"
                                    inputmode="email"
                                    placeholder="vous@exemple.com"
                                    @error('email') aria-invalid="true" aria-describedby="email-error" @enderror
                                    class="w-full rounded-xl border {{ $errors->has('email') ? 'border-[#b85e32]' : 'border-[#dfe3d8]' }} bg-[#fcfbf7] py-3.5 pl-11 pr-4 text-sm text-[#18382b] outline-none transition placeholder:text-[#a0a99f] focus:border-[#1d4935] focus:ring-4 focus:ring-[#1d4935]/10"
                                >
                            </div>
                            @error('email')
                                <p id="email-error" class="mt-2 text-xs font-medium text-[#a44735]">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <div class="mb-2 flex items-center justify-between gap-3">
                                <label for="password" class="text-sm font-semibold text-[#274535]">Mot de passe</label>
                                <a href="{{ route('password.request') }}" class="text-xs font-semibold text-[#1d6847] transition hover:text-[#b85e32] hover:underline">
                                    Mot de passe oublié ?
                                </a>
                            </div>
                            <div class="relative">
                                <i class="fa-solid fa-lock pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-[#8a9589]" aria-hidden="true"></i>
                                <input
                                    id="password"
                                    :type="showPassword ? 'text' : 'password'"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                    placeholder="Saisissez votre mot de passe"
                                    class="w-full rounded-xl border {{ $errors->has('email') ? 'border-[#b85e32]' : 'border-[#dfe3d8]' }} bg-[#fcfbf7] py-3.5 pl-11 pr-12 text-sm text-[#18382b] outline-none transition placeholder:text-[#a0a99f] focus:border-[#1d4935] focus:ring-4 focus:ring-[#1d4935]/10"
                                >
                                <button
                                    type="button"
                                    @click="showPassword = !showPassword"
                                    :aria-label="showPassword ? 'Masquer le mot de passe' : 'Afficher le mot de passe'"
                                    class="absolute right-3 top-1/2 flex h-9 w-9 -translate-y-1/2 items-center justify-center rounded-lg text-[#7b897d] transition hover:bg-[#e8f0e8] hover:text-[#1d4935]"
                                >
                                    <i :class="showPassword ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye'" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>

                        <label for="remember" class="flex cursor-pointer items-center gap-3 text-sm text-[#526258]">
                            <input
                                type="checkbox"
                                name="remember"
                                id="remember"
                                value="1"
                                @checked(old('remember'))
                                class="h-4 w-4 rounded border-[#cbd4c9] text-[#1d4935] accent-[#1d4935] focus:ring-[#1d4935]/30"
                            >
                            <span>Rester connecté sur cet appareil</span>
                        </label>

                        <button type="submit" class="inline-flex w-full items-center justify-center gap-3 rounded-full bg-[#1d4935] px-6 py-4 text-sm font-bold text-white shadow-lg shadow-[#1d4935]/15 transition hover:-translate-y-0.5 hover:bg-[#143a29] focus:outline-none focus:ring-4 focus:ring-[#1d4935]/20">
                            Se connecter
                            <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                        </button>
                    </form>

                    <div class="relative flex items-center gap-4" aria-hidden="true">
                        <span class="h-px flex-1 bg-[#e5e9e0]"></span>
                        <span class="text-xs font-medium text-[#8a9589]">ou continuer avec</span>
                        <span class="h-px flex-1 bg-[#e5e9e0]"></span>
                    </div>

                    <a href="{{ route('auth.google.redirect') }}" class="flex w-full items-center justify-center gap-3 rounded-full border border-[#d9ded5] bg-white px-5 py-3.5 text-sm font-bold text-[#274535] transition hover:border-[#aebcae] hover:bg-[#f8f7f1] focus:outline-none focus:ring-4 focus:ring-[#1d4935]/10">
                        <svg class="h-5 w-5" viewBox="0 0 48 48" aria-hidden="true">
                            <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                            <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.73 7.18l7.64 5.93c4.46-4.12 7.13-10.18 7.13-17.58z"/>
                            <path fill="#FBBC05" d="M10.53 28.59a14.4 14.4 0 0 1 0-9.18l-7.98-6.19a23.9 23.9 0 0 0 0 21.56l7.98-6.19z"/>
                            <path fill="#34A853" d="M24 48c6.47 0 11.91-2.13 15.88-5.87l-7.64-5.93c-2.12 1.42-4.84 2.27-8.24 2.27-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                        </svg>
                        Continuer avec Google
                    </a>

                    <p class="border-t border-[#edf0e9] pt-5 text-center text-sm text-[#647167]">
                        Vous n’avez pas encore de compte ?
                        <a href="{{ route('register') }}" class="font-bold text-[#1d4935] transition hover:text-[#b85e32] hover:underline">Créer un compte</a>
                    </p>
                </div>
            </div>
        </div>

        <aside class="relative order-2 hidden min-h-[620px] overflow-hidden rounded-[2rem] bg-[#1d4935] shadow-2xl shadow-[#18382b]/15 sm:block">
            <div class="pointer-events-none absolute -right-24 -top-16 h-96 w-96 rounded-full border border-white/10" aria-hidden="true"></div>
            <div class="pointer-events-none absolute -right-6 top-10 h-64 w-64 rounded-full border border-[#efb18e]/20" aria-hidden="true"></div>
            <div class="pointer-events-none absolute -bottom-24 -left-24 h-80 w-80 rounded-full bg-[#d87842]/15 blur-3xl" aria-hidden="true"></div>
            <i class="fa-solid fa-earth-africa pointer-events-none absolute right-[-2rem] top-28 text-[20rem] text-white/[0.035]" aria-hidden="true"></i>

            <div class="relative flex min-h-[620px] flex-col justify-between p-7 text-white sm:p-10">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="" class="h-11 w-11 rounded-xl object-cover">
                    <span>
                        <span class="block font-display text-base font-bold tracking-wide">AFRICODE <span class="text-[#efb18e]">LAB</span></span>
                        <span class="mt-0.5 block text-[10px] font-semibold uppercase tracking-[0.14em] text-white/60">Le numérique africain en mouvement</span>
                    </span>
                </div>

                <div class="relative max-w-lg py-12">
                    <span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1.5 text-xs font-semibold text-[#f2d7c4] backdrop-blur">
                        <i class="fa-solid fa-earth-africa" aria-hidden="true"></i>
                        Une initiative panafricaine
                    </span>
                    <h2 class="mt-5 font-display text-3xl font-bold leading-tight sm:text-4xl">
                        Le numérique africain doit aussi <span class="text-[#efb18e]">s’écrire en Afrique.</span>
                    </h2>
                    <p class="mt-4 max-w-lg text-sm leading-6 text-white/80 sm:text-base">
                        Retrouvez une communauté de professionnels et de talents engagés pour imaginer et construire des solutions utiles au continent.
                    </p>
                    <a href="{{ route('membership.create') }}" class="mt-6 inline-flex items-center gap-2 text-sm font-bold text-white transition hover:text-[#efb18e]">
                        Découvrir comment contribuer
                        <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
                    </a>
                </div>

                <div class="grid grid-cols-3 gap-3 border-t border-white/15 pt-5">
                    <div>
                        <i class="fa-solid fa-lightbulb text-sm text-[#efb18e]" aria-hidden="true"></i>
                        <p class="mt-2 text-xs font-semibold text-white/85">Idées locales</p>
                    </div>
                    <div>
                        <i class="fa-solid fa-people-group text-sm text-[#efb18e]" aria-hidden="true"></i>
                        <p class="mt-2 text-xs font-semibold text-white/85">Talents réunis</p>
                    </div>
                    <div>
                        <i class="fa-solid fa-handshake-angle text-sm text-[#efb18e]" aria-hidden="true"></i>
                        <p class="mt-2 text-xs font-semibold text-white/85">Impact collectif</p>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</section>
@endsection
