@extends('layouts.app')

@section('title', 'Projets & réalisations — AfriCode Lab')
@section('meta_description', 'Découvrez des projets numériques conçus par les talents et contributeurs d’AfriCode Lab.')

@section('content')
<section class="bg-[#f6f3eb] py-14 sm:py-20">
    <div class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-12">
        <div class="grid items-end gap-10 lg:grid-cols-[1fr_auto]">
            <div class="max-w-3xl">
                <p class="inline-flex items-center gap-2 rounded-full border border-[#d9ded5] bg-white px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-[#b85e32]">
                    <span class="h-2 w-2 rounded-full bg-[#b85e32]"></span>
                    Des idées au service des usages
                </p>
                <h1 class="mt-6 font-display text-4xl font-bold leading-tight text-[#18382b] sm:text-5xl lg:text-6xl">
                    Des projets concrets, portés par des talents engagés.
                </h1>
                <p class="mt-5 max-w-2xl text-base leading-8 text-[#647167] sm:text-lg">
                    Explorez les réalisations de notre communauté : des outils numériques imaginés pour répondre à des besoins réels et faire grandir les initiatives africaines.
                </p>
            </div>
            <a href="{{ route('contribute') }}" class="inline-flex items-center justify-center gap-2 justify-self-start rounded-full bg-[#1d4935] px-6 py-3.5 text-sm font-bold text-white transition hover:bg-[#18382b] lg:justify-self-end">
                Présenter un projet <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
            </a>
        </div>

        <div class="mt-10 flex flex-col gap-4 border-t border-[#d9ded5] pt-6 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-sm font-semibold text-[#526258]">
                {{ $projects->count() }} {{ $projects->count() === 1 ? 'projet présenté' : 'projets présentés' }}
            </p>
            <form method="GET" action="{{ route('projects') }}" class="flex w-full flex-col gap-2 sm:w-auto sm:flex-row">
                <label for="domain" class="sr-only">Filtrer par domaine</label>
                <select id="domain" name="domain" class="min-h-11 rounded-full border border-[#d9ded5] bg-white px-4 text-sm text-[#304b3a] outline-none focus:border-[#1d4935]">
                    <option value="">Tous les domaines</option>
                    @foreach($domains as $domain)
                        <option value="{{ $domain }}" @selected(request('domain') === $domain)>{{ $domain }}</option>
                    @endforeach
                </select>
                <button type="submit" class="min-h-11 rounded-full border border-[#cbd4c9] px-5 text-sm font-bold text-[#1d4935] transition hover:border-[#1d4935]">
                    Filtrer
                </button>
            </form>
        </div>

        @if($projects->isNotEmpty())
            <div class="mt-7 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach($projects as $project)
                    <article class="group flex h-full flex-col overflow-hidden rounded-[1.75rem] border border-[#e5e4dc] bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-[#18382b]/10">
                        <div class="relative aspect-[16/10] overflow-hidden bg-[#e8eee5]">
                            @if($project->image_path)
                                <img src="{{ asset($project->image_path) }}" alt="Maquette illustrative du projet {{ $project->title }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.03]">
                            @else
                                <div class="flex h-full items-center justify-center text-5xl text-[#1d4935]" aria-hidden="true">
                                    <i class="fa-solid fa-laptop-code"></i>
                                </div>
                            @endif
                            @if($project->is_featured)
                                <span class="absolute left-4 top-4 inline-flex items-center gap-1.5 rounded-full bg-white/95 px-3 py-1.5 text-[11px] font-bold text-[#8a5b2c] shadow-sm">
                                    <i class="fa-solid fa-star text-[#b85e32]" aria-hidden="true"></i> À la une
                                </span>
                            @endif
                        </div>

                        <div class="flex flex-1 flex-col p-6 sm:p-7">
                            <span class="self-start rounded-full bg-[#e8eee5] px-3 py-1.5 text-[11px] font-bold uppercase tracking-wide text-[#1d4935]">{{ $project->domain }}</span>
                            <h2 class="mt-4 font-display text-2xl font-bold text-[#18382b]">{{ $project->title }}</h2>
                            <p class="mt-3 flex-1 text-sm leading-7 text-[#647167]">{{ $project->description }}</p>
                            <p class="mt-5 border-t border-[#e9e7df] pt-4 text-xs font-semibold text-[#526258]">
                                {{ $project->technologies }}
                            </p>
                            <div class="mt-5 flex flex-wrap items-center justify-between gap-3">
                                <span class="inline-flex items-center gap-2 text-xs font-semibold text-[#526258]">
                                    <i class="fa-regular fa-user text-[#b85e32]" aria-hidden="true"></i>
                                    {{ $project->author_name }}
                                </span>
                                @if($project->demo_url)
                                    <a href="{{ $project->demo_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full bg-[#1d4935] px-4 py-2.5 text-xs font-bold text-white transition hover:bg-[#18382b]">
                                        Voir le projet <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="mt-7 rounded-3xl border border-dashed border-[#cbd4c9] bg-white px-6 py-14 text-center">
                <span class="mx-auto inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-[#e8eee5] text-xl text-[#1d4935]">
                    <i class="fa-solid fa-lightbulb" aria-hidden="true"></i>
                </span>
                <h2 class="mt-5 font-display text-xl font-bold text-[#18382b]">Aucun projet dans ce domaine pour le moment.</h2>
                <p class="mt-2 text-sm leading-6 text-[#647167]">Essayez un autre filtre ou revenez découvrir les prochaines réalisations.</p>
                @if(request()->filled('domain'))
                    <a href="{{ route('projects') }}" class="mt-5 inline-flex rounded-full border border-[#cbd4c9] px-5 py-2.5 text-sm font-bold text-[#1d4935] hover:border-[#1d4935]">Voir tous les projets</a>
                @endif
            </div>
        @endif
    </div>
</section>

<section class="bg-[#1d4935] py-14 text-white sm:py-16">
    <div class="mx-auto flex max-w-7xl flex-col gap-6 px-5 sm:px-8 md:flex-row md:items-center md:justify-between lg:px-12">
        <div class="max-w-2xl">
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#e6b17f]">Vous avez une idée à partager ?</p>
            <h2 class="mt-3 font-display text-2xl font-bold sm:text-3xl">Faisons connaître les solutions qui font la différence.</h2>
        </div>
        <a href="{{ route('contribute') }}" class="inline-flex shrink-0 items-center justify-center gap-2 self-start rounded-full bg-[#e6b17f] px-6 py-3.5 text-sm font-bold text-[#18382b] transition hover:bg-[#efc69e] md:self-auto">
            Rejoindre les contributeurs <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
        </a>
    </div>
</section>
@endsection
