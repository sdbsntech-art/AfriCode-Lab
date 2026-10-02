@extends('layouts.dashboard')

@section('title', 'Mes Formations — AfriCode Lab')
@section('header_title', 'Mes Formations & Cours')

@section('content')
<div class="space-y-10">
    
    <!-- Enrolled Formations -->
    <div class="space-y-4">
        <h2 class="text-xl font-bold font-display text-white">Formations où vous êtes inscrit</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($myEnrollments as $enrollment)
                <div class="glass-panel p-6 rounded-2xl border border-slate-800 space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="px-3 py-1 rounded-full text-xs font-code font-bold uppercase bg-cyan-500/20 text-cyan-300 border border-cyan-500/30">
                            {{ $enrollment->formation->domain }}
                        </span>
                        <span class="text-xs font-code font-bold text-emerald-400">{{ $enrollment->progress_percent }}% complété</span>
                    </div>

                    <h3 class="text-lg font-bold text-white">{{ $enrollment->formation->title }}</h3>
                    <p class="text-xs text-slate-300 leading-relaxed">{{ $enrollment->formation->summary }}</p>

                    <div class="w-full bg-slate-900 rounded-full h-2">
                        <div class="bg-gradient-to-r from-cyan-400 to-emerald-400 h-2 rounded-full" style="width: {{ $enrollment->progress_percent }}%"></div>
                    </div>

                    <div class="pt-4 border-t border-slate-800 flex items-center justify-between">
                        <span class="text-xs text-slate-400"><i class="fa-solid fa-layer-group text-purple-400 mr-1"></i> {{ $enrollment->formation->modules->count() }} Modules</span>
                        <a href="{{ route('dashboard.learn', ['formationId' => $enrollment->formation->id]) }}" class="px-4 py-2 rounded-xl bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-bold text-xs shadow-neon transition-all">
                            Accéder aux cours <i class="fa-solid fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-slate-400 text-sm col-span-2">Vous n'avez pas encore d'inscription active.</p>
            @endforelse
        </div>
    </div>

    <!-- Available Formations catalog to enroll -->
    <div class="space-y-4 pt-6 border-t border-slate-800">
        <h2 class="text-xl font-bold font-display text-white">Autres Formations Disponibles</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($otherFormations as $formation)
                <div class="glass-panel p-6 rounded-2xl border border-slate-800 space-y-4 flex flex-col justify-between">
                    <div class="space-y-3">
                        <span class="px-3 py-1 rounded-full text-xs font-code uppercase font-bold bg-slate-800 text-slate-300 border border-slate-700">
                            {{ $formation->domain }}
                        </span>
                        <h3 class="text-base font-bold text-white">{{ $formation->title }}</h3>
                        <p class="text-xs text-slate-300 leading-relaxed line-clamp-3">{{ $formation->summary }}</p>
                    </div>

                    <form method="POST" action="{{ route('dashboard.enroll', $formation->id) }}" class="pt-4 border-t border-slate-800">
                        @csrf
                        <button type="submit" class="w-full py-2.5 rounded-xl bg-emerald-500/20 hover:bg-emerald-500/30 text-emerald-300 font-bold text-xs border border-emerald-500/40 transition-all">
                            S'inscrire maintenant
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
