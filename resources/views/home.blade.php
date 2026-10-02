@extends('layouts.app')

@section('title', 'AfriCode Lab — Le numérique africain s’écrit aussi en Afrique')
@section('meta_description', 'Découvrez la vision d’AfriCode Lab : fédérer les talents et les professionnels pour construire des solutions numériques utiles à l’Afrique. Rejoignez notre mission.')

@section('content')
<section class="relative overflow-hidden bg-[#f6f3eb]">
    <div class="absolute -right-36 -top-32 h-96 w-96 rounded-full bg-[#e6a15a]/15 blur-3xl" aria-hidden="true"></div>
    <div class="mx-auto grid max-w-7xl items-center gap-12 px-5 py-16 sm:px-8 sm:py-24 lg:grid-cols-2 lg:gap-16 lg:px-12 lg:py-28">
        <div class="relative z-10">
            <span class="inline-flex items-center gap-2 rounded-full border border-[#d9dfcf] bg-white/80 px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-[#315b43]">
                <span class="h-2 w-2 rounded-full bg-[#d87842]"></span>
                Une initiative panafricaine
            </span>

            <h1 class="mt-7 max-w-2xl font-display text-4xl font-bold leading-[1.08] tracking-tight text-[#18382b] sm:text-5xl lg:text-6xl">
                Le numérique africain doit aussi
                <span class="text-[#b85e32]">s’écrire en Afrique.</span>
            </h1>

            <p class="mt-6 max-w-xl text-lg leading-8 text-[#526258]">
                AfriCode Lab rassemble les talents, les idées et les énergies qui feront émerger des solutions numériques pensées avec et pour le continent.
            </p>
            <p class="mt-4 max-w-xl text-base leading-7 text-[#526258]">
                Notre ambition : créer un mouvement durable autour des compétences, de l’innovation locale et de la coopération entre professionnels et communautés.
            </p>

            <div class="mt-9 flex flex-col gap-3 sm:flex-row">
                <a href="{{ route('membership.create') }}" class="inline-flex items-center justify-center gap-3 rounded-full bg-[#1d4935] px-7 py-4 text-sm font-bold text-white shadow-lg shadow-[#1d4935]/15 transition hover:-translate-y-0.5 hover:bg-[#143a29]">
                    Adhérer à AfriCode Lab
                    <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                </a>
                <a href="#programme" class="inline-flex items-center justify-center gap-2 rounded-full border border-[#ccd4c8] bg-white/70 px-7 py-4 text-sm font-bold text-[#274535] transition hover:border-[#1d4935] hover:bg-white">
                    Découvrir le programme
                </a>
            </div>

            <div class="mt-10 flex flex-wrap items-center gap-x-6 gap-y-3 border-t border-[#d9ded5] pt-6 text-sm text-[#526258]">
                <span class="inline-flex items-center gap-2"><i class="fa-solid fa-earth-africa text-[#b85e32]" aria-hidden="true"></i> Une vision panafricaine</span>
                <span class="inline-flex items-center gap-2"><i class="fa-solid fa-people-group text-[#b85e32]" aria-hidden="true"></i> Une dynamique collective</span>
            </div>
        </div>

        <div class="relative mx-auto w-full max-w-xl lg:ml-auto">
            <div class="absolute -left-5 top-10 h-24 w-24 rounded-full border border-[#d87842]/30 sm:-left-8 sm:h-32 sm:w-32" aria-hidden="true"></div>
            <div class="relative overflow-hidden rounded-[2rem] bg-[#1d4935] p-3 shadow-2xl shadow-[#18382b]/15">
                <div class="relative min-h-[430px] overflow-hidden rounded-[1.5rem] sm:min-h-[520px]">
                    <img src="{{ asset('images/afrique_hero.jpg') }}" alt="L’Afrique, au cœur de la vision d’AfriCode Lab" class="absolute inset-0 h-full w-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#102c20]/95 via-[#102c20]/20 to-transparent"></div>
                    <div class="absolute left-5 top-5 flex items-center gap-3 rounded-2xl bg-[#f6f3eb]/95 px-4 py-3 shadow-lg sm:left-7 sm:top-7">
                        <img src="{{ asset('images/logo.jpeg') }}" alt="" class="h-10 w-10 rounded-xl object-cover">
                        <div>
                            <p class="font-display text-sm font-bold tracking-wide text-[#18382b]">AFRICODE LAB</p>
                            <p class="text-[10px] font-semibold uppercase tracking-[0.14em] text-[#69776c]">Innover. Transmettre. Bâtir.</p>
                        </div>
                    </div>
                    <div class="absolute inset-x-6 bottom-7 sm:inset-x-8 sm:bottom-9">
                        <span class="inline-flex rounded-full bg-[#e6a15a] px-3 py-1.5 text-[11px] font-bold uppercase tracking-wider text-[#18382b]">Notre cap</span>
                        <p class="mt-4 max-w-md font-display text-2xl font-bold leading-tight text-white sm:text-3xl">
                            Faire du numérique un levier de réponses aux défis africains.
                        </p>
                    </div>
                </div>
            </div>
            <div class="absolute -bottom-5 right-3 rounded-2xl border border-[#e7e2d7] bg-white px-4 py-3 shadow-xl sm:-right-5 sm:px-5 sm:py-4">
                <p class="text-xs font-semibold uppercase tracking-wider text-[#718075]">Une ambition commune</p>
                <p class="mt-1 font-display text-sm font-bold text-[#1d4935]">L’Afrique construit son avenir.</p>
            </div>
        </div>
    </div>
</section>

<section class="bg-[#1d4935] py-20 text-white sm:py-24">
    <div class="mx-auto grid max-w-7xl gap-12 px-5 sm:px-8 lg:grid-cols-12 lg:items-end lg:px-12">
        <div class="lg:col-span-5">
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#e6a15a]">Pourquoi AfriCode Lab ?</p>
            <h2 class="mt-5 font-display text-3xl font-bold leading-tight sm:text-4xl">
                Le potentiel est là. Construisons ce qui manque.
            </h2>
        </div>
        <div class="lg:col-span-6 lg:col-start-7">
            <p class="text-base leading-8 text-white/80">
                Les talents et les idées ne manquent pas sur le continent. Pour les faire grandir, il faut des espaces de collaboration, des occasions de partager l’expérience et des projets qui répondent aux réalités locales.
            </p>
            <p class="mt-4 text-base leading-8 text-white/80">
                AfriCode Lab veut contribuer à bâtir ces passerelles — et ouvrir cette aventure à toutes celles et ceux qui souhaitent y prendre part.
            </p>
        </div>
    </div>
</section>

<section id="programme" class="scroll-mt-24 bg-white py-20 sm:py-24">
    <div class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-12">
        <div class="max-w-2xl">
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#b85e32]">Notre programme</p>
            <h2 class="mt-4 font-display text-3xl font-bold leading-tight text-[#18382b] sm:text-4xl">
                Une vision qui se transforme en actions.
            </h2>
            <p class="mt-5 text-base leading-7 text-[#647167]">
                Un programme ouvert, construit autour de la transmission, de projets concrets et d’un réseau engagé au service de l’innovation africaine.
            </p>
        </div>

        <div class="mt-12 grid gap-5 md:grid-cols-3">
            <article class="rounded-3xl border border-[#e5e4dc] bg-[#faf9f5] p-7 sm:p-8">
                <span class="font-display text-sm font-bold text-[#b85e32]">01 / TRANSMETTRE</span>
                <div class="mt-7 flex h-12 w-12 items-center justify-center rounded-2xl bg-[#e8eee5] text-xl text-[#1d4935]">
                    <i class="fa-solid fa-lightbulb" aria-hidden="true"></i>
                </div>
                <h3 class="mt-5 font-display text-xl font-bold text-[#18382b]">Faire circuler l’expérience</h3>
                <p class="mt-3 text-sm leading-7 text-[#647167]">Créer des occasions de partage entre professionnels, talents émergents et communautés numériques.</p>
            </article>

            <article class="rounded-3xl border border-[#e5e4dc] bg-[#faf9f5] p-7 sm:p-8">
                <span class="font-display text-sm font-bold text-[#b85e32]">02 / EXPÉRIMENTER</span>
                <div class="mt-7 flex h-12 w-12 items-center justify-center rounded-2xl bg-[#f6e9dc] text-xl text-[#b85e32]">
                    <i class="fa-solid fa-cubes-stacked" aria-hidden="true"></i>
                </div>
                <h3 class="mt-5 font-display text-xl font-bold text-[#18382b]">Construire des réponses locales</h3>
                <p class="mt-3 text-sm leading-7 text-[#647167]">Mettre les compétences en mouvement autour de projets numériques ancrés dans les besoins du continent.</p>
            </article>

            <article class="rounded-3xl border border-[#e5e4dc] bg-[#faf9f5] p-7 sm:p-8">
                <span class="font-display text-sm font-bold text-[#b85e32]">03 / FÉDÉRER</span>
                <div class="mt-7 flex h-12 w-12 items-center justify-center rounded-2xl bg-[#e8eee5] text-xl text-[#1d4935]">
                    <i class="fa-solid fa-people-group" aria-hidden="true"></i>
                </div>
                <h3 class="mt-5 font-display text-xl font-bold text-[#18382b]">Relier les forces du continent</h3>
                <p class="mt-3 text-sm leading-7 text-[#647167]">Faire grandir un réseau de professionnels, de partenaires et de contributeurs qui avancent dans la même direction.</p>
            </article>
        </div>

        <div class="mt-8 flex flex-wrap gap-3">
            <a href="{{ route('about') }}" class="inline-flex items-center gap-2 rounded-full px-5 py-3 text-sm font-bold text-[#1d4935] transition hover:bg-[#edf0e9]">
                En savoir plus sur notre vision <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
            </a>
            <a href="{{ route('community') }}" class="inline-flex items-center gap-2 rounded-full px-5 py-3 text-sm font-bold text-[#1d4935] transition hover:bg-[#edf0e9]">
                Découvrir la communauté <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</section>

<section class="bg-[#f2efe6] py-20 sm:py-24">
    <div class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-12">
        <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
            <div class="max-w-2xl">
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#b85e32]">Le numérique en action</p>
                <h2 class="mt-4 font-display text-3xl font-bold text-[#18382b] sm:text-4xl">Des idées qui prennent forme.</h2>
                <p class="mt-4 text-base leading-7 text-[#647167]">Les projets sont un terrain de rencontre entre les compétences et les besoins de nos communautés.</p>
            </div>
            <a href="{{ route('projects') }}" class="inline-flex shrink-0 items-center gap-2 self-start rounded-full border border-[#cbd4c9] bg-white px-5 py-3 text-sm font-bold text-[#1d4935] transition hover:border-[#1d4935] sm:self-auto">
                Tous les projets <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
            </a>
        </div>

        <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($featuredProjects as $project)
                <article class="overflow-hidden rounded-3xl border border-[#e3e0d6] bg-white shadow-sm">
                    <div class="relative h-52 overflow-hidden bg-[#dfe6dd]">
                        <img src="{{ asset($project->image_path ?? 'images/code.jpg') }}" alt="{{ $project->title }}" class="h-full w-full object-cover transition duration-500 hover:scale-105">
                        @if($project->domain)
                            <span class="absolute left-4 top-4 rounded-full bg-white/95 px-3 py-1.5 text-xs font-bold text-[#1d4935]">{{ $project->domain }}</span>
                        @endif
                    </div>
                    <div class="p-6">
                        <h3 class="font-display text-xl font-bold text-[#18382b]">{{ $project->title }}</h3>
                        <p class="mt-3 text-sm leading-6 text-[#647167]">{{ $project->description }}</p>
                        @if($project->technologies)
                            <p class="mt-5 text-xs font-semibold uppercase tracking-wider text-[#b85e32]">{{ $project->technologies }}</p>
                        @endif
                    </div>
                </article>
            @empty
                <div class="rounded-3xl border border-dashed border-[#cbd4c9] bg-white/70 p-8 sm:col-span-2 lg:col-span-3">
                    <p class="font-display text-xl font-bold text-[#18382b]">Le prochain projet peut être le vôtre.</p>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-[#647167]">AfriCode Lab ouvre un espace aux idées et aux talents qui souhaitent participer à des initiatives numériques utiles au continent.</p>
                    <a href="{{ route('contribute') }}" class="mt-5 inline-flex items-center gap-2 text-sm font-bold text-[#1d4935] hover:text-[#b85e32]">
                        Proposer votre contribution <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</section>

<section class="bg-[#e9a15b] py-20 sm:py-24">
    <div class="mx-auto max-w-5xl px-5 text-center sm:px-8">
        <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#56361f]">Rejoignez le mouvement</p>
        <h2 class="mx-auto mt-5 max-w-3xl font-display text-3xl font-bold leading-tight text-[#18382b] sm:text-5xl">
            Votre expérience peut contribuer à changer la suite.
        </h2>
        <p class="mx-auto mt-5 max-w-2xl text-base leading-7 text-[#493d30]">
            Vous êtes professionnel du numérique, porteur de projet, partenaire ou simplement convaincu que l’Afrique doit prendre sa place dans le monde numérique ? Nous serions heureux de construire avec vous.
        </p>
        <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
            <a href="{{ route('membership.create') }}" class="inline-flex items-center justify-center gap-3 rounded-full bg-[#1d4935] px-8 py-4 text-sm font-bold text-white shadow-lg transition hover:-translate-y-0.5 hover:bg-[#143a29]">
                Adhérer à AfriCode Lab
                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </a>
            <a href="{{ route('contribute') }}" class="inline-flex items-center justify-center gap-3 rounded-full border border-[#1d4935]/30 bg-white/60 px-8 py-4 text-sm font-bold text-[#18382b] transition hover:-translate-y-0.5 hover:bg-white">
                Proposer une contribution
            </a>
        </div>
        <p class="mt-5 text-sm text-[#493d30]">Un premier échange ne vous engage à rien.</p>
    </div>
</section>
@endsection
