@extends('layouts.admin')

@section('title', 'Témoignages — Admin AfriCode Lab')
@section('header_title', 'Gestion des Témoignages Apprenants')

@section('content')
<div class="space-y-8">

    <!-- Header Toggle Form -->
    <div x-data="{ showForm: false }" class="space-y-4">
        <div class="flex items-center justify-between glass-card p-6 rounded-2xl border border-slate-800/80">
            <div>
                <h2 class="text-xl font-bold font-display text-white flex items-center gap-2">
                    <i class="fa-solid fa-quote-left text-purple-400"></i> Témoignages de la Communauté ({{ $testimonials->count() }})
                </h2>
                <p class="text-xs text-slate-400 mt-1">Publiez et modérez les retours d'expérience des apprenants.</p>
            </div>
            <button @click="showForm = !showForm" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-purple-500 to-indigo-500 hover:from-purple-400 hover:to-indigo-400 text-white font-extrabold text-xs shadow-glow-purple transition-all flex items-center gap-2">
                <i class="fa-solid fa-plus text-sm"></i> <span x-text="showForm ? 'Masquer Formulaire' : 'Nouveau Témoignage'"></span>
            </button>
        </div>

        <div x-show="showForm" x-cloak class="glass-card p-6 sm:p-8 rounded-3xl border border-purple-500/30 shadow-2xl space-y-6">
            <form method="POST" action="{{ route('admin.testimonials.store') }}" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-2">Nom & Prénom *</label>
                        <input type="text" name="name" required placeholder="ex: Emmanuel Kassi" class="w-full px-4 py-3 rounded-xl bg-slate-900/90 border border-slate-800 text-white focus:border-purple-500 focus:outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-2">Poste / Titre Professionnel *</label>
                        <input type="text" name="role_title" required class="w-full px-4 py-3 rounded-xl bg-slate-900/90 border border-slate-800 text-white focus:border-purple-500 focus:outline-none text-sm" placeholder="Développeur Full-Stack chez TechAfrica">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-2">Avis / Témoignage *</label>
                    <textarea name="content" rows="3" required class="w-full px-4 py-3 rounded-xl bg-slate-900/90 border border-slate-800 text-white focus:border-purple-500 focus:outline-none text-sm leading-relaxed"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-2">Note sur 5 (Nombre d'étoiles) *</label>
                    <input type="number" name="rating" value="5" min="1" max="5" required class="w-32 px-4 py-3 rounded-xl bg-slate-900/90 border border-slate-800 text-white focus:border-purple-500 focus:outline-none text-sm font-code">
                </div>
                <button type="submit" class="px-7 py-3 rounded-xl bg-gradient-to-r from-purple-500 to-indigo-500 hover:from-purple-400 hover:to-indigo-400 text-white font-extrabold text-xs shadow-glow-purple transition-all">
                    <i class="fa-solid fa-check mr-2"></i> Publier le Témoignage
                </button>
            </form>
        </div>
    </div>

    <!-- Testimonials List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($testimonials as $t)
            <div class="glass-card p-6 rounded-2xl border border-slate-800/80 space-y-4 flex flex-col justify-between hover:border-purple-500/40 transition-all shadow-xl">
                <div class="space-y-3">
                    <div class="flex items-center gap-1 text-amber-400 text-xs">
                        @for($i = 0; $i < $t->rating; $i++) <i class="fa-solid fa-star"></i> @endfor
                    </div>
                    <p class="text-xs text-slate-300 leading-relaxed italic">« {{ $t->content }} »</p>
                </div>
                <div class="pt-3 border-t border-slate-800/80 flex items-center justify-between">
                    <div>
                        <p class="font-bold text-white text-xs">{{ $t->name }}</p>
                        <p class="text-[10px] text-slate-400 font-code">{{ $t->role_title }}</p>
                    </div>
                    <form method="POST" action="{{ route('admin.testimonials.delete', $t->id) }}" onsubmit="return confirm('Supprimer ce témoignage ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-8 h-8 rounded-lg bg-rose-500/15 text-rose-400 hover:bg-rose-500/30 flex items-center justify-center transition-all inline-flex"><i class="fa-solid fa-trash text-xs"></i></button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
