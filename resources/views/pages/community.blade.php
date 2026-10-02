@extends('layouts.app')

@section('title', 'Communauté — AfriCode Lab')
@section('meta_description', 'Rejoignez le réseau panafricain de professionnels, experts et partenaires qui font avancer le numérique en Afrique avec AfriCode Lab.')

@section('content')
<section class="bg-[#f6f3eb] py-14 sm:py-20">
    <div class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-12">
        <div class="grid items-center gap-12 lg:grid-cols-[1.1fr_0.9fr] lg:gap-16">
            <div class="max-w-2xl">
                <p class="inline-flex items-center gap-2 rounded-full border border-[#d9ded5] bg-white/80 px-4 py-2 text-xs font-bold uppercase tracking-[0.16em] text-[#b85e32]">
                    <span class="h-2 w-2 rounded-full bg-[#b85e32]"></span>
                    Le réseau AfriCode Lab
                </p>
                <h1 class="mt-7 font-display text-4xl font-bold leading-[1.12] tracking-tight text-[#18382b] sm:text-5xl lg:text-6xl">
                    Une communauté qui fait avancer le numérique africain.
                </h1>
                <p class="mt-6 max-w-xl text-base leading-8 text-[#647167] sm:text-lg">
                    AfriCode Lab rassemble des professionnels, des experts, des partenaires et des passionnés autour d’une ambition commune : mettre les compétences en mouvement pour bâtir des solutions utiles au continent.
                </p>
                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('membership.create') }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#1d4935] px-6 py-3.5 text-sm font-bold text-white transition hover:bg-[#18382b]">
                        Rejoindre la communauté <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
                    </a>
                    <a href="{{ route('contribute') }}" class="inline-flex items-center justify-center gap-2 rounded-full border border-[#cbd4c9] bg-white px-6 py-3.5 text-sm font-bold text-[#1d4935] transition hover:border-[#1d4935]">
                        Proposer une contribution
                    </a>
                </div>
                <p class="mt-5 text-xs leading-5 text-[#778178]">Professionnels · Mentors · Partenaires · Contributeurs</p>
            </div>

            <div class="relative mx-auto w-full max-w-xl">
                <div class="absolute -right-3 -top-3 h-24 w-24 rounded-full bg-[#e6b17f]/50 blur-2xl sm:-right-5 sm:-top-5"></div>
                <div class="relative overflow-hidden rounded-[2rem] bg-[#1d4935] p-7 text-white shadow-xl shadow-[#18382b]/10 sm:p-10">
                    <div class="absolute -bottom-20 -right-12 h-64 w-64 rounded-full border border-white/10"></div>
                    <div class="absolute -bottom-12 -right-4 h-48 w-48 rounded-full border border-white/10"></div>
                    <div class="relative">
                        <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-white/10 text-xl text-[#e6b17f]">
                            <i class="fa-solid fa-people-group" aria-hidden="true"></i>
                        </span>
                        <p class="mt-9 text-xs font-bold uppercase tracking-[0.2em] text-[#e6b17f]">Notre force collective</p>
                        <blockquote class="mt-4 font-display text-2xl font-bold leading-snug sm:text-3xl">
                            « Les talents existent. Relions-les aux opportunités et aux défis de notre continent. »
                        </blockquote>
                        <div class="mt-8 flex items-center gap-3 border-t border-white/15 pt-5">
                            <span class="h-1 w-10 rounded-full bg-[#e6b17f]"></span>
                            <span class="text-sm font-semibold text-white/75">La vision AfriCode Lab</span>
                        </div>
                    </div>
                </div>
                <div class="relative mt-4 grid grid-cols-2 gap-3">
                    <div class="rounded-2xl border border-[#e5e4dc] bg-white p-4">
                        <i class="fa-solid fa-lightbulb text-lg text-[#b85e32]" aria-hidden="true"></i>
                        <p class="mt-3 text-sm font-bold text-[#18382b]">Partager les idées</p>
                        <p class="mt-1 text-xs leading-5 text-[#647167]">Faire émerger des réponses aux enjeux locaux.</p>
                    </div>
                    <div class="rounded-2xl border border-[#e5e4dc] bg-white p-4">
                        <i class="fa-solid fa-handshake-angle text-lg text-[#1d4935]" aria-hidden="true"></i>
                        <p class="mt-3 text-sm font-bold text-[#18382b]">Construire ensemble</p>
                        <p class="mt-1 text-xs leading-5 text-[#647167]">Mettre l’expertise au service de projets utiles.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-white py-16 sm:py-20" id="evenements">
    <div class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-12">
        <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
            <div class="max-w-2xl">
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#b85e32]">Se retrouver et agir</p>
                <h2 class="mt-4 font-display text-3xl font-bold text-[#18382b] sm:text-4xl">Événements & hackathons</h2>
                <p class="mt-4 text-base leading-7 text-[#647167]">Des temps forts pour échanger, collaborer et faire avancer des idées avec la communauté.</p>
            </div>
            <a href="{{ route('membership.create') }}" class="inline-flex shrink-0 items-center gap-2 self-start rounded-full border border-[#cbd4c9] px-5 py-3 text-sm font-bold text-[#1d4935] transition hover:border-[#1d4935] sm:self-auto">
                Rester informé <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
            </a>
        </div>

        @if($events->isNotEmpty())
            <div class="mt-9 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                @foreach($events as $event)
                    <article class="flex h-full flex-col rounded-3xl border border-[#e5e4dc] bg-[#faf9f5] p-6 transition hover:-translate-y-1 hover:border-[#cbd4c9] hover:shadow-lg hover:shadow-[#18382b]/5">
                        <div class="flex items-start justify-between gap-4">
                            <span class="rounded-full bg-[#e8eee5] px-3 py-1.5 text-[11px] font-bold uppercase tracking-wide text-[#1d4935]">{{ $event->type }}</span>
                            <span class="shrink-0 text-right text-xs font-semibold text-[#647167]">
                                @if($event->event_date)
                                    <i class="fa-regular fa-calendar-days mr-1 text-[#b85e32]" aria-hidden="true"></i>
                                    {{ $event->event_date->format('d/m/Y') }}
                                    @if($event->event_time) · {{ $event->event_time }} @endif
                                @else
                                    <i class="fa-regular fa-clock mr-1 text-[#b85e32]" aria-hidden="true"></i>
                                    Date à venir
                                @endif
                            </span>
                        </div>
                        <h3 class="mt-5 font-display text-xl font-bold text-[#18382b]">{{ $event->title }}</h3>
                        <p class="mt-3 flex-1 text-sm leading-6 text-[#647167]">{{ $event->description }}</p>
                        <div class="mt-6 flex flex-wrap items-center justify-between gap-3 border-t border-[#e5e4dc] pt-4">
                            <span class="inline-flex items-center gap-2 text-xs font-medium text-[#647167]">
                                <i class="fa-solid fa-location-dot text-[#b85e32]" aria-hidden="true"></i>
                                {{ $event->location }}
                            </span>
                            @if($event->registration_url)
                                <a href="{{ $event->registration_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-xs font-bold text-[#1d4935] hover:text-[#b85e32]">
                                    Participer <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
                                </a>
                            @else
                                <span class="text-xs font-semibold text-[#778178]">Informations à venir</span>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="mt-9 rounded-3xl border border-dashed border-[#cbd4c9] bg-[#faf9f5] px-6 py-12 text-center sm:px-10">
                <span class="mx-auto inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-[#e8eee5] text-xl text-[#1d4935]">
                    <i class="fa-regular fa-calendar" aria-hidden="true"></i>
                </span>
                <h3 class="mt-5 font-display text-xl font-bold text-[#18382b]">Les prochains rendez-vous se préparent.</h3>
                <p class="mx-auto mt-2 max-w-lg text-sm leading-6 text-[#647167]">Aucun événement n’est programmé pour le moment. Rejoignez le réseau pour rester informé des prochaines rencontres.</p>
                <a href="{{ route('membership.create') }}" class="mt-6 inline-flex items-center gap-2 rounded-full bg-[#1d4935] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#18382b]">
                    Rejoindre le réseau <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
                </a>
            </div>
        @endif
    </div>
</section>

@if($testimonials->isNotEmpty())
    <section class="bg-[#f2efe6] py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-12">
            <div class="mx-auto max-w-2xl text-center">
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#b85e32]">Paroles de la communauté</p>
                <h2 class="mt-4 font-display text-3xl font-bold text-[#18382b] sm:text-4xl">Des parcours, une même envie d’agir.</h2>
            </div>
            <div class="mt-9 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                @foreach($testimonials as $testimonial)
                    <figure class="rounded-3xl border border-[#e5e4dc] bg-white p-6 sm:p-7">
                        <div class="flex gap-1 text-sm text-[#b85e32]" aria-label="Note : {{ $testimonial->rating }} sur 5">
                            @for($star = 0; $star < $testimonial->rating; $star++)
                                <i class="fa-solid fa-star" aria-hidden="true"></i>
                            @endfor
                        </div>
                        <blockquote class="mt-5 text-sm leading-7 text-[#526258]">“{{ $testimonial->content }}”</blockquote>
                        <figcaption class="mt-6 flex items-center gap-3 border-t border-[#e9e7df] pt-5">
                            @if($testimonial->avatar)
                                <img src="{{ asset($testimonial->avatar) }}" alt="" class="h-11 w-11 rounded-full object-cover">
                            @else
                                <span class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-[#e8eee5] font-display text-sm font-bold text-[#1d4935]">
                                    {{ mb_substr($testimonial->name, 0, 1) }}
                                </span>
                            @endif
                            <span>
                                <span class="block text-sm font-bold text-[#18382b]">{{ $testimonial->name }}</span>
                                <span class="mt-0.5 block text-xs text-[#778178]">{{ $testimonial->role_title }}</span>
                            </span>
                        </figcaption>
                    </figure>
                @endforeach
            </div>
        </div>
    </section>
@endif

<section class="bg-[#1d4935] py-16 text-white sm:py-20">
    <div class="mx-auto flex max-w-7xl flex-col gap-8 px-5 sm:px-8 lg:flex-row lg:items-center lg:justify-between lg:px-12">
        <div class="max-w-2xl">
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#e6b17f]">Votre place est parmi nous</p>
            <h2 class="mt-4 font-display text-3xl font-bold leading-tight sm:text-4xl">Faites partie de celles et ceux qui construisent la suite.</h2>
            <p class="mt-4 text-sm leading-7 text-white/75 sm:text-base">Que vous souhaitiez adhérer, partager votre expertise ou créer un partenariat, votre contribution peut faire la différence.</p>
        </div>
        <div class="flex shrink-0 flex-col gap-3 sm:flex-row">
            <a href="{{ route('membership.create') }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#e6b17f] px-6 py-3.5 text-sm font-bold text-[#18382b] transition hover:bg-[#efc69e]">
                Candidater à l’adhésion <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
            </a>
            <a href="{{ route('contribute') }}" class="inline-flex items-center justify-center rounded-full border border-white/30 px-6 py-3.5 text-sm font-bold text-white transition hover:bg-white/10">
                Contribuer
            </a>
        </div>
    </div>
</section>
@endsection
