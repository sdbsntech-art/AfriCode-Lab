@extends('layouts.app')

@section('title', 'Notre vision — AfriCode Lab')
@section('meta_description', 'Découvrez la vision, les ambitions et les engagements d’AfriCode Lab pour contribuer au développement du numérique en Afrique.')

@section('content')
<section class="bg-[#f6f3eb]">
    <div class="mx-auto max-w-7xl px-5 py-16 sm:px-8 sm:py-24 lg:px-12">
        <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-16">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#b85e32]">Notre raison d’être</p>
                <h1 class="mt-5 font-display text-4xl font-bold leading-tight text-[#18382b] sm:text-5xl">
                    L’avenir numérique de l’Afrique se construit ensemble.
                </h1>
                <p class="mt-6 text-lg leading-8 text-[#526258]">
                    AfriCode Lab est une initiative panafricaine portée par une conviction : le continent doit pouvoir compter sur ses talents pour imaginer et bâtir ses propres réponses aux défis numériques.
                </p>
                <p class="mt-4 text-base leading-7 text-[#647167]">
                    Notre rôle est de créer des passerelles entre les compétences, les idées, les projets et les professionnels qui veulent contribuer à cette ambition.
                </p>
                <a href="{{ route('contribute') }}" class="mt-8 inline-flex items-center gap-3 rounded-full bg-[#1d4935] px-7 py-4 text-sm font-bold text-white transition hover:bg-[#143a29]">
                    Construire avec nous <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                </a>
            </div>
            <div class="relative">
                <div class="absolute -bottom-4 -left-4 h-28 w-28 rounded-3xl bg-[#e9a15b]" aria-hidden="true"></div>
                <img src="{{ asset('images/afrique_hero.jpg') }}" alt="Le continent africain au cœur de la vision d’AfriCode Lab" class="relative h-[360px] w-full rounded-[2rem] object-cover shadow-xl sm:h-[460px]">
            </div>
        </div>
    </div>
</section>

<section class="bg-white py-20 sm:py-24">
    <div class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-12">
        <div class="max-w-2xl">
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#b85e32]">Notre ambition</p>
            <h2 class="mt-4 font-display text-3xl font-bold text-[#18382b] sm:text-4xl">Faire grandir une force numérique africaine.</h2>
            <p class="mt-5 text-base leading-7 text-[#647167]">
                Nous voulons contribuer à un écosystème dans lequel les talents africains disposent de l’espace, des liens et des moyens pour participer pleinement à l’innovation.
            </p>
        </div>

        <div class="mt-12 grid gap-5 md:grid-cols-3">
            <article class="rounded-3xl border border-[#e5e4dc] bg-[#faf9f5] p-7">
                <span class="font-display text-sm font-bold text-[#b85e32]">01</span>
                <h3 class="mt-5 font-display text-xl font-bold text-[#18382b]">Faire confiance aux talents</h3>
                <p class="mt-3 text-sm leading-7 text-[#647167]">Valoriser les compétences locales et faciliter les rencontres entre celles et ceux qui ont l’envie de construire.</p>
            </article>
            <article class="rounded-3xl border border-[#e5e4dc] bg-[#faf9f5] p-7">
                <span class="font-display text-sm font-bold text-[#b85e32]">02</span>
                <h3 class="mt-5 font-display text-xl font-bold text-[#18382b]">Répondre à nos réalités</h3>
                <p class="mt-3 text-sm leading-7 text-[#647167]">Encourager des initiatives technologiques ancrées dans les défis et les opportunités des communautés africaines.</p>
            </article>
            <article class="rounded-3xl border border-[#e5e4dc] bg-[#faf9f5] p-7">
                <span class="font-display text-sm font-bold text-[#b85e32]">03</span>
                <h3 class="mt-5 font-display text-xl font-bold text-[#18382b]">Avancer ensemble</h3>
                <p class="mt-3 text-sm leading-7 text-[#647167]">Tisser des liens durables entre professionnels, porteurs de projets, organisations et communautés du continent.</p>
            </article>
        </div>
    </div>
</section>

<section class="bg-[#1d4935] py-16 text-white sm:py-20">
    <div class="mx-auto flex max-w-7xl flex-col gap-6 px-5 sm:px-8 md:flex-row md:items-center md:justify-between lg:px-12">
        <div class="max-w-2xl">
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#e9a15b]">Une vision ouverte</p>
            <h2 class="mt-3 font-display text-2xl font-bold sm:text-3xl">Il y a une place pour votre énergie et votre expérience.</h2>
        </div>
        <a href="{{ route('contribute') }}" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-full bg-[#e9a15b] px-6 py-4 text-sm font-bold text-[#18382b] transition hover:bg-[#f0b776]">
            Rejoindre la mission <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
        </a>
    </div>
</section>
@endsection
