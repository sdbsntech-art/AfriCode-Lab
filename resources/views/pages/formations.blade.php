@extends('layouts.app')

@section('title', 'Formations — AfriCode Lab')

@section('content')
<div class="py-16 bg-grid-pattern">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center max-w-3xl mx-auto mb-12 space-y-4">
            <span class="px-3 py-1 rounded-full text-xs font-code font-bold uppercase bg-emerald-500/10 text-emerald-400 border border-emerald-500/30">
                Nos Domaines d'Excellence
            </span>
            <h1 class="text-4xl sm:text-5xl font-extrabold font-display text-white">
                Catalogue des Formations AfriCode Lab
            </h1>
            <p class="text-slate-300 text-base">
                Découvrez nos programmes d'apprentissage intensifs conçus par des experts du secteur.
            </p>
        </div>

        <!-- Domain Filters -->
        <div class="flex flex-wrap items-center justify-center gap-3 mb-12">
            <a href="{{ route('formations') }}" class="px-5 py-2.5 rounded-xl font-medium text-sm transition-all {{ !request('domain') ? 'bg-cyan-500 text-slate-950 font-bold shadow-neon' : 'glass-panel text-slate-300 hover:text-white' }}">
                Toutes les formations
            </a>
            <a href="{{ route('formations', ['domain' => 'dev']) }}" class="px-5 py-2.5 rounded-xl font-medium text-sm transition-all {{ request('domain') === 'dev' ? 'bg-cyan-500 text-slate-950 font-bold shadow-neon' : 'glass-panel text-slate-300 hover:text-white' }}">
                <i class="fa-solid fa-code mr-1.5"></i> Développement
            </a>
            <a href="{{ route('formations', ['domain' => 'cyber']) }}" class="px-5 py-2.5 rounded-xl font-medium text-sm transition-all {{ request('domain') === 'cyber' ? 'bg-emerald-500 text-slate-950 font-bold shadow-neonGreen' : 'glass-panel text-slate-300 hover:text-white' }}">
                <i class="fa-solid fa-shield-halved mr-1.5"></i> Cybersécurité
            </a>
            <a href="{{ route('formations', ['domain' => 'data']) }}" class="px-5 py-2.5 rounded-xl font-medium text-sm transition-all {{ request('domain') === 'data' ? 'bg-purple-500 text-white font-bold' : 'glass-panel text-slate-300 hover:text-white' }}">
                <i class="fa-solid fa-database mr-1.5"></i> Data & IA
            </a>
            <a href="{{ route('formations', ['domain' => 'network']) }}" class="px-5 py-2.5 rounded-xl font-medium text-sm transition-all {{ request('domain') === 'network' ? 'bg-amber-500 text-slate-950 font-bold' : 'glass-panel text-slate-300 hover:text-white' }}">
                <i class="fa-solid fa-server mr-1.5"></i> Réseaux
            </a>
            <a href="{{ route('formations', ['domain' => 'devops']) }}" class="px-5 py-2.5 rounded-xl font-medium text-sm transition-all {{ request('domain') === 'devops' ? 'bg-teal-500 text-slate-950 font-bold' : 'glass-panel text-slate-300 hover:text-white' }}">
                <i class="fa-solid fa-cloud mr-1.5"></i> DevOps & Cloud
            </a>
        </div>

        <!-- Formations Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($formations as $formation)
                <div class="glass-panel rounded-3xl p-6 border border-slate-800 hover:border-cyan-500/50 transition-all flex flex-col justify-between group shadow-xl">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="w-12 h-12 rounded-2xl bg-cyan-500/10 border border-cyan-500/30 flex items-center justify-center text-cyan-400 text-xl font-bold">
                                @if($formation->domain === 'dev') <i class="fa-solid fa-code"></i>
                                @elseif($formation->domain === 'cyber') <i class="fa-solid fa-shield-halved"></i>
                                @elseif($formation->domain === 'data') <i class="fa-solid fa-database"></i>
                                @elseif($formation->domain === 'network') <i class="fa-solid fa-server"></i>
                                @else <i class="fa-solid fa-cloud"></i>
                                @endif
                            </div>
                            <span class="px-3 py-1 rounded-full text-[11px] font-semibold font-code uppercase bg-slate-800 text-cyan-300 border border-slate-700">
                                {{ $formation->badge ?? $formation->level }}
                            </span>
                        </div>

                        <h3 class="text-xl font-bold text-white group-hover:text-cyan-400 transition-colors">
                            {{ $formation->title }}
                        </h3>

                        <p class="text-xs text-slate-300 leading-relaxed">
                            {{ $formation->summary }}
                        </p>
                    </div>

                    <div class="pt-6 mt-6 border-t border-slate-800 flex items-center justify-between text-xs text-slate-400">
                        <span><i class="fa-regular fa-clock mr-1"></i> {{ $formation->duration }}</span>
                        <a href="{{ route('formations.show', $formation->slug) }}" class="px-4 py-2 rounded-xl bg-cyan-500/10 hover:bg-cyan-500/20 text-cyan-300 font-semibold border border-cyan-500/30 transition-all">
                            Voir la formation
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12 text-slate-400">
                    Aucune formation trouvée dans cette catégorie pour le moment.
                </div>
            @endforelse
        </div>

    </div>
</div>
@endsection
