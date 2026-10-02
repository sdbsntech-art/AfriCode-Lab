@extends('layouts.app')

@section('title', $formation->title . ' — AfriCode Lab')

@section('content')
<div class="py-12 bg-grid-pattern">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb -->
        <nav class="flex text-xs text-slate-400 mb-8" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-white">Accueil</a>
            <span class="mx-2">/</span>
            <a href="{{ route('formations') }}" class="hover:text-white">Formations</a>
            <span class="mx-2">/</span>
            <span class="text-cyan-400 font-semibold truncate">{{ $formation->title }}</span>
        </nav>

        <!-- Formation Header Card -->
        <div class="glass-panel p-8 sm:p-10 rounded-3xl border border-slate-700/80 mb-12 shadow-2xl relative overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                
                <div class="lg:col-span-8 space-y-4">
                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1 rounded-full text-xs font-code font-bold uppercase bg-cyan-500/20 text-cyan-300 border border-cyan-500/30">
                            {{ $formation->domain }}
                        </span>
                        <span class="px-3 py-1 rounded-full text-xs font-code font-bold uppercase bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                            {{ $formation->level }}
                        </span>
                    </div>

                    <h1 class="text-3xl sm:text-4xl font-extrabold font-display text-white">
                        {{ $formation->title }}
                    </h1>

                    <p class="text-base text-slate-300 leading-relaxed">
                        {{ $formation->description }}
                    </p>

                    <div class="flex flex-wrap items-center gap-6 pt-4 text-xs font-code text-slate-400">
                        <div><i class="fa-regular fa-clock text-cyan-400 mr-1"></i> Durée : <span class="text-white font-bold">{{ $formation->duration }}</span></div>
                        <div><i class="fa-solid fa-graduation-cap text-emerald-400 mr-1"></i> Apprenants : <span class="text-white font-bold">{{ $formation->students_count }}+</span></div>
                        <div><i class="fa-solid fa-layer-group text-purple-400 mr-1"></i> Modules : <span class="text-white font-bold">{{ $formation->modules->count() }}</span></div>
                    </div>
                </div>

                <div class="lg:col-span-4 flex flex-col items-center lg:items-end justify-center">
                    @auth
                        @if($isEnrolled)
                            <a href="{{ route('dashboard.learn', ['formationId' => $formation->id]) }}" class="w-full text-center px-8 py-4 rounded-2xl bg-gradient-to-r from-emerald-400 to-teal-400 text-slate-950 font-extrabold text-base shadow-neonGreen hover:scale-105 transition-all">
                                <i class="fa-solid fa-circle-play mr-2"></i> Continuer les cours
                            </a>
                        @else
                            <form method="POST" action="{{ route('dashboard.enroll', $formation->id) }}" class="w-full">
                                @csrf
                                <button type="submit" class="w-full px-8 py-4 rounded-2xl bg-gradient-to-r from-cyan-400 via-emerald-400 to-teal-400 text-slate-950 font-extrabold text-base shadow-neon hover:scale-105 transition-all">
                                    <i class="fa-solid fa-user-plus mr-2"></i> S'inscrire à cette formation
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('register') }}" class="w-full text-center px-8 py-4 rounded-2xl bg-gradient-to-r from-cyan-400 via-emerald-400 to-teal-400 text-slate-950 font-extrabold text-base shadow-neon hover:scale-105 transition-all">
                            S'inscrire gratuitement
                        </a>
                        <p class="text-xs text-slate-400 mt-2 text-center">Accès immédiat à la plateforme</p>
                    @endauth
                </div>

            </div>
        </div>

        <!-- Curriculum Breakdown -->
        <div class="space-y-6">
            <h2 class="text-2xl font-bold font-display text-white">Programme détaillé de la formation</h2>

            <div class="space-y-4">
                @foreach($formation->modules as $index => $module)
                    <div x-data="{ open: true }" class="glass-panel rounded-2xl border border-slate-800 overflow-hidden">
                        <button @click="open = !open" class="w-full px-6 py-4 flex items-center justify-between text-left hover:bg-slate-800/40 transition-colors">
                            <div class="flex items-center gap-4">
                                <span class="w-8 h-8 rounded-xl bg-cyan-500/20 border border-cyan-400 text-cyan-400 font-bold text-xs flex items-center justify-center font-code">
                                    {{ $index + 1 }}
                                </span>
                                <div>
                                    <h3 class="font-bold text-white text-base">{{ $module->title }}</h3>
                                    <p class="text-xs text-slate-400">{{ $module->description }}</p>
                                </div>
                            </div>
                            <i class="fa-solid text-slate-400 transition-transform" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                        </button>

                        <div x-show="open" class="px-6 py-4 border-t border-slate-800/80 bg-slate-950/40 space-y-3">
                            @foreach($module->courses as $course)
                                <div class="flex items-center justify-between p-3 rounded-xl bg-slate-900/60 border border-slate-800/60 text-xs">
                                    <div class="flex items-center gap-3">
                                        <i class="fa-regular fa-circle-play text-cyan-400 text-sm"></i>
                                        <span class="font-medium text-slate-200">{{ $course->title }}</span>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="text-slate-400"><i class="fa-regular fa-clock mr-1"></i> {{ $course->duration }}</span>
                                        @if($course->is_free_preview)
                                            <span class="px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-300 font-code text-[10px]">Aperçu Gratuit</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
@endsection
