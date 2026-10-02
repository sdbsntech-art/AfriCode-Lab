@extends('layouts.admin')

@section('title', 'Gestion Formations — Admin AfriCode Lab')
@section('header_title', 'Gestion des Formations & Modules')

@section('content')
<div class="space-y-8">

    <!-- Header Actions Toggle -->
    <div x-data="{ showForm: false }" class="space-y-4">
        <div class="flex items-center justify-between glass-card p-6 rounded-2xl border border-slate-800/80">
            <div>
                <h2 class="text-xl font-bold font-display text-white flex items-center gap-2">
                    <i class="fa-solid fa-graduation-cap text-emerald-400"></i> Catalogue des Formations ({{ $formations->count() }})
                </h2>
                <p class="text-xs text-slate-400 mt-1">Créez et administrez les parcours d'apprentissage de l'académie.</p>
            </div>
            <button @click="showForm = !showForm" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-extrabold text-xs shadow-glow-emerald transition-all flex items-center gap-2">
                <i class="fa-solid fa-plus text-sm"></i> <span x-text="showForm ? 'Masquer Formulaire' : 'Nouvelle Formation'"></span>
            </button>
        </div>

        <div x-show="showForm" x-cloak class="glass-card p-6 sm:p-8 rounded-3xl border border-emerald-500/30 shadow-2xl space-y-6">
            <form method="POST" action="{{ route('admin.formations.store') }}" class="space-y-5">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-2">Titre de la Formation *</label>
                        <input type="text" name="title" required placeholder="ex: Développement Web Full-Stack avec Laravel 13" class="w-full px-4 py-3 rounded-xl bg-slate-900/90 border border-slate-800 text-white focus:border-emerald-500 focus:outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-2">Domaine Spécialisé *</label>
                        <select name="domain" required class="w-full px-4 py-3 rounded-xl bg-slate-900/90 border border-slate-800 text-white focus:border-emerald-500 focus:outline-none text-sm cursor-pointer">
                            <option value="dev">Développement & Programmation</option>
                            <option value="cyber">Cybersécurité & Ethical Hacking</option>
                            <option value="data">Data & Intelligence Artificielle</option>
                            <option value="network">Réseaux & Infrastructures</option>
                            <option value="devops">DevOps & Cloud Engineering</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-2">Icône FontAwesome *</label>
                        <input type="text" name="icon" value="code" required class="w-full px-4 py-3 rounded-xl bg-slate-900/90 border border-slate-800 text-white focus:border-emerald-500 focus:outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-2">Niveau Exigé *</label>
                        <input type="text" name="level" value="Fondamentaux & Spécialisation" required class="w-full px-4 py-3 rounded-xl bg-slate-900/90 border border-slate-800 text-white focus:border-emerald-500 focus:outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-2">Durée *</label>
                        <input type="text" name="duration" value="6 mois (300h)" required class="w-full px-4 py-3 rounded-xl bg-slate-900/90 border border-slate-800 text-white focus:border-emerald-500 focus:outline-none text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-2">Badge d'Honneur (Optionnel)</label>
                    <input type="text" name="badge" class="w-full px-4 py-3 rounded-xl bg-slate-900/90 border border-slate-800 text-white focus:border-emerald-500 focus:outline-none text-sm" placeholder="ex: Populaire, Critique, Innovant...">
                </div>
                <div>
                    <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-2">Résumé Synthétique *</label>
                    <textarea name="summary" rows="2" required class="w-full px-4 py-3 rounded-xl bg-slate-900/90 border border-slate-800 text-white focus:border-emerald-500 focus:outline-none text-sm leading-relaxed"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-2">Description Détaillée & Programme *</label>
                    <textarea name="description" rows="4" required class="w-full px-4 py-3 rounded-xl bg-slate-900/90 border border-slate-800 text-white focus:border-emerald-500 focus:outline-none text-sm leading-relaxed"></textarea>
                </div>
                <div class="flex items-center gap-4">
                    <label class="flex items-center gap-2 text-xs text-slate-300 cursor-pointer">
                        <input type="checkbox" name="is_featured" class="w-4 h-4 rounded bg-slate-900 border-slate-800 text-emerald-500"> Mettre en avant sur la page d'accueil
                    </label>
                </div>
                <button type="submit" class="px-8 py-3 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-extrabold text-xs shadow-glow-emerald transition-all">
                    <i class="fa-solid fa-check mr-2"></i> Enregistrer et Publier
                </button>
            </form>
        </div>
    </div>

    <!-- Formations Table -->
    <div class="glass-card rounded-2xl border border-slate-800/80 overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-950/60 border-b border-slate-800/80 text-slate-400 uppercase font-code">
                    <tr>
                        <th class="px-6 py-4">Formation</th>
                        <th class="px-4 py-4">Domaine</th>
                        <th class="text-center px-4 py-4">Modules</th>
                        <th class="text-center px-4 py-4">Apprenants Inscrits</th>
                        <th class="text-center px-4 py-4">Visibilité</th>
                        <th class="text-right px-6 py-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @foreach($formations as $formation)
                        <tr class="hover:bg-slate-800/40 transition-colors">
                            <td class="px-6 py-4 font-bold text-white max-w-xs truncate">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-500/15 border border-emerald-500/30 flex items-center justify-center text-emerald-400">
                                        <i class="fa-solid fa-{{ $formation->icon ?? 'code' }}"></i>
                                    </div>
                                    <span>{{ $formation->title }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-4"><span class="px-2.5 py-1 rounded-full bg-slate-900 border border-slate-800 text-cyan-400 font-code font-bold uppercase text-[10px]">{{ $formation->domain }}</span></td>
                            <td class="px-4 py-4 text-center font-bold text-slate-200">{{ $formation->modules_count }} modules</td>
                            <td class="px-4 py-4 text-center text-emerald-400 font-extrabold font-code">{{ $formation->enrollments_count }}</td>
                            <td class="px-4 py-4 text-center">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-code font-bold {{ $formation->is_published ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : 'bg-rose-500/20 text-rose-300 border border-rose-500/30' }}">
                                    {{ $formation->is_published ? 'Publiée' : 'Brouillon' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form method="POST" action="{{ route('admin.formations.delete', $formation->id) }}" class="inline" onsubmit="return confirm('Supprimer cette formation ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 rounded-lg bg-rose-500/15 text-rose-400 hover:bg-rose-500/25 border border-rose-500/30 font-bold transition-all text-xs">
                                        <i class="fa-solid fa-trash mr-1"></i> Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
