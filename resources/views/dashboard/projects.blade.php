@extends('layouts.dashboard')

@section('title', 'Mes Projets — AfriCode Lab')
@section('header_title', 'Mes Projets & Réalisations')

@section('content')
<div class="space-y-8">

    <!-- New Project Form -->
    <div x-data="{ showForm: false }" class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold font-display text-white">Proposer un projet à la galerie</h2>
            <button @click="showForm = !showForm" class="px-5 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-500 text-white font-bold text-xs transition-all">
                <i class="fa-solid fa-plus mr-1"></i> <span x-text="showForm ? 'Masquer' : 'Nouveau Projet'"></span>
            </button>
        </div>

        <p class="text-sm text-slate-400">Chaque projet est vérifié par l’administration avant sa publication sur le site.</p>
        <div x-show="showForm" x-cloak class="glass-panel p-6 sm:p-8 rounded-2xl border border-slate-800 shadow-xl">
            <form method="POST" action="{{ route('dashboard.projects.store') }}" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-1.5">Titre du Projet *</label>
                        <input type="text" name="title" required class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 text-white focus:border-cyan-500 focus:outline-none text-sm" placeholder="AfriPay Mobile...">
                    </div>

                    <div>
                        <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-1.5">Domaine *</label>
                        <input type="text" name="domain" required class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 text-white focus:border-cyan-500 focus:outline-none text-sm" placeholder="Développement Web, Cybersécurité...">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-1.5">Technologies utilisées *</label>
                    <input type="text" name="technologies" required class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 text-white focus:border-cyan-500 focus:outline-none text-sm" placeholder="Laravel 13, Vue.js, MySQL, Docker...">
                </div>

                <div>
                    <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-1.5">Description du Projet *</label>
                    <textarea name="description" rows="3" required class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 text-white focus:border-cyan-500 focus:outline-none text-sm" placeholder="Décrivez ce que fait votre projet et les problèmes qu'il résout..."></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-1.5">Lien GitHub</label>
                        <input type="url" name="github_url" class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 text-white focus:border-cyan-500 focus:outline-none text-sm" placeholder="https://github.com/votre-repo">
                    </div>

                    <div>
                        <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-1.5">Lien Démo</label>
                        <input type="url" name="demo_url" class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 text-white focus:border-cyan-500 focus:outline-none text-sm" placeholder="https://demo.monprojet.com">
                    </div>
                </div>

                <button type="submit" class="px-6 py-3 rounded-xl bg-gradient-to-r from-purple-500 to-indigo-500 text-white font-extrabold text-sm hover:scale-[1.01] transition-all shadow-lg">
                    <i class="fa-solid fa-rocket mr-2"></i> Publier le projet
                </button>
            </form>
        </div>
    </div>

    <!-- Existing Projects List -->
    <div class="space-y-4">
        <h2 class="text-xl font-bold font-display text-white">Mes Projets Publiés</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($projects as $project)
                <div class="glass-panel p-6 rounded-2xl border border-slate-800 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="px-3 py-1 rounded-full text-[10px] font-code uppercase font-bold bg-purple-500/20 text-purple-300 border border-purple-500/30">
                            {{ $project->domain }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between gap-3">
                        <h3 class="text-lg font-bold text-white">{{ $project->title }}</h3>
                        <span class="text-[10px] font-code font-bold {{ $project->is_approved ? 'text-emerald-400' : 'text-amber-400' }}">
                            {{ $project->is_approved ? '✓ Publié' : '⏳ En revue' }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-300 leading-relaxed">{{ Str::limit($project->description, 120) }}</p>
                    <p class="text-xs font-code text-emerald-400">{{ $project->technologies }}</p>

                    <div class="flex items-center gap-3 text-xs text-slate-400 pt-2 border-t border-slate-800">
                        @if($project->github_url)
                            <a href="{{ $project->github_url }}" target="_blank" class="hover:text-white"><i class="fa-brands fa-github mr-1"></i> GitHub</a>
                        @endif
                        @if($project->demo_url)
                            <a href="{{ $project->demo_url }}" target="_blank" class="hover:text-cyan-400"><i class="fa-solid fa-arrow-up-right-from-square mr-1"></i> Demo</a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-2 glass-panel p-8 rounded-2xl border border-slate-800 text-center space-y-3">
                    <i class="fa-solid fa-code-fork text-3xl text-slate-600"></i>
                    <p class="text-slate-300 text-sm">Vous n'avez publié aucun projet pour le moment. Publiez votre premier projet ci-dessus !</p>
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
