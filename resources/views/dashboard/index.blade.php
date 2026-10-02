@extends('layouts.dashboard')

@section('title', 'Tableau de Bord — AfriCode Lab')
@section('header_title', 'Bienvenue, ' . auth()->user()->name)

@section('content')
<div class="space-y-8">
    
    <!-- Welcome Banner -->
    <div class="glass-panel p-8 rounded-3xl border border-slate-700/80 bg-gradient-to-r from-slate-950 via-slate-900 to-cyan-950/40 relative overflow-hidden shadow-2xl">
        <div class="relative z-10 space-y-3">
            <span class="px-3 py-1 rounded-full text-xs font-code font-bold uppercase bg-cyan-500/20 text-cyan-300 border border-cyan-500/30">
                Espace Apprenant
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold font-display text-white">
                Ravi de vous revoir, {{ auth()->user()->name }} ! 👋
            </h2>
            <p class="text-sm text-slate-300 max-w-2xl leading-relaxed">
                Poursuivez vos apprentissages pour construire vos projets informatiques et propulser votre carrière dans les métiers du numérique en Afrique.
            </p>
        </div>
    </div>

    <!-- 4 Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <div class="glass-panel p-6 rounded-2xl border border-slate-800 space-y-2">
            <div class="flex items-center justify-between text-slate-400">
                <span class="text-xs uppercase font-code font-bold">Formations En Cours</span>
                <i class="fa-solid fa-graduation-cap text-cyan-400 text-lg"></i>
            </div>
            <span class="text-3xl font-bold font-display text-white">{{ $totalEnrollments }}</span>
            <p class="text-[11px] text-slate-400">Inscrit activement</p>
        </div>

        <div class="glass-panel p-6 rounded-2xl border border-slate-800 space-y-2">
            <div class="flex items-center justify-between text-slate-400">
                <span class="text-xs uppercase font-code font-bold">Progression Moyenne</span>
                <i class="fa-solid fa-chart-line text-emerald-400 text-lg"></i>
            </div>
            <span class="text-3xl font-bold font-display text-emerald-400">{{ $avgProgress }}%</span>
            <div class="w-full bg-slate-900 rounded-full h-2 mt-2">
                <div class="bg-gradient-to-r from-cyan-400 to-emerald-400 h-2 rounded-full" style="width: {{ $avgProgress }}%"></div>
            </div>
        </div>

        <div class="glass-panel p-6 rounded-2xl border border-slate-800 space-y-2">
            <div class="flex items-center justify-between text-slate-400">
                <span class="text-xs uppercase font-code font-bold">Projets Publiés</span>
                <i class="fa-solid fa-code-branch text-purple-400 text-lg"></i>
            </div>
            <span class="text-3xl font-bold font-display text-purple-400">{{ $userProjects->count() }}</span>
            <p class="text-[11px] text-slate-400">Dans la galerie publiques</p>
        </div>

        <div class="glass-panel p-6 rounded-2xl border border-slate-800 space-y-2">
            <div class="flex items-center justify-between text-slate-400">
                <span class="text-xs uppercase font-code font-bold">Formations Complétées</span>
                <i class="fa-solid fa-trophy text-amber-400 text-lg"></i>
            </div>
            <span class="text-3xl font-bold font-display text-amber-400">{{ $completedFormations }}</span>
            <p class="text-[11px] text-slate-400">Certificats obtenus</p>
        </div>

    </div>

    <!-- Active Formations Grid -->
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="text-xl font-bold font-display text-white">Mes Formations en Cours</h3>
            <a href="{{ route('dashboard.courses') }}" class="text-xs font-bold text-cyan-400 hover:underline">Voir tout</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($enrollments as $enrollment)
                <div class="glass-panel p-6 rounded-2xl border border-slate-800 space-y-4 flex flex-col justify-between">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-code uppercase font-bold bg-cyan-500/20 text-cyan-300 border border-cyan-500/30">
                                {{ $enrollment->formation->domain }}
                            </span>
                            <span class="text-xs font-code font-bold text-emerald-400">{{ $enrollment->progress_percent }}% accompli</span>
                        </div>

                        <h4 class="text-lg font-bold text-white">{{ $enrollment->formation->title }}</h4>
                        
                        <div class="w-full bg-slate-900 rounded-full h-2">
                            <div class="bg-gradient-to-r from-cyan-400 to-emerald-400 h-2 rounded-full" style="width: {{ $enrollment->progress_percent }}%"></div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-800 flex items-center justify-between">
                        <span class="text-xs text-slate-400"><i class="fa-regular fa-clock mr-1"></i> {{ $enrollment->formation->duration }}</span>
                        <a href="{{ route('dashboard.learn', ['formationId' => $enrollment->formation->id]) }}" class="px-4 py-2 rounded-xl bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-bold text-xs shadow-neon transition-all">
                            Reprendre la leçon
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-2 glass-panel p-8 rounded-2xl border border-slate-800 text-center space-y-3">
                    <i class="fa-solid fa-graduation-cap text-3xl text-slate-600"></i>
                    <p class="text-slate-300 text-sm">Vous n'êtes inscrit à aucune formation pour le moment.</p>
                    <a href="{{ route('formations') }}" class="inline-block px-6 py-2.5 rounded-xl bg-cyan-500 text-slate-950 font-bold text-xs">
                        Découvrir les formations
                    </a>
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
