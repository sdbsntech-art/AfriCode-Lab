@extends('layouts.admin')

@section('title', 'Gestion Événements — Admin AfriCode Lab')
@section('header_title', 'Gestion des Événements & Calendrier')

@section('content')
<div class="space-y-8">

    <!-- Create Event Form Toggle Header -->
    <div x-data="{ showForm: false }" class="space-y-4">
        <div class="flex items-center justify-between glass-card p-6 rounded-2xl border border-slate-800/80">
            <div>
                <h2 class="text-xl font-bold font-display text-white flex items-center gap-2">
                    <i class="fa-solid fa-calendar-days text-teal-400"></i> Événements & Webinaires ({{ $events->count() }})
                </h2>
                <p class="text-xs text-slate-400 mt-1">Publiez de nouveaux événements ou fixez leurs dates pour la communauté.</p>
            </div>
            <button @click="showForm = !showForm" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-teal-500 to-emerald-500 hover:from-teal-400 hover:to-emerald-400 text-slate-950 font-extrabold text-xs shadow-glow-emerald transition-all flex items-center gap-2">
                <i class="fa-solid fa-plus text-sm"></i> <span x-text="showForm ? 'Masquer Formulaire' : 'Créer un Événement'"></span>
            </button>
        </div>

        <div x-show="showForm" x-cloak class="glass-card p-6 sm:p-8 rounded-3xl border border-teal-500/30 shadow-2xl space-y-6">
            <form method="POST" action="{{ route('admin.events.store') }}" class="space-y-5">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-2">Titre de l'événement *</label>
                        <input type="text" name="title" required placeholder="ex: Apprentissage : Créer un site avec l'IA" class="w-full px-4 py-3 rounded-xl bg-slate-900/90 border border-slate-800 text-white focus:border-teal-500 focus:outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-2">Type d'événement *</label>
                        <select name="type" required class="w-full px-4 py-3 rounded-xl bg-slate-900/90 border border-slate-800 text-white focus:border-teal-500 focus:outline-none text-sm cursor-pointer">
                            <option value="Webinaire">Webinaire</option>
                            <option value="Atelier">Atelier Pratique</option>
                            <option value="Hackathon">Hackathon</option>
                            <option value="Conférence">Conférence Panafricaine</option>
                        </select>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-2">Date (Facultative)</label>
                        <input type="date" name="event_date" class="w-full px-4 py-3 rounded-xl bg-slate-900/90 border border-slate-800 text-white focus:border-teal-500 focus:outline-none text-sm">
                        <p class="text-[10px] text-teal-400 mt-1">Laissez vide pour afficher "À venir dans les plus brefs délais"</p>
                    </div>
                    <div>
                        <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-2">Heure (GMT)</label>
                        <input type="text" name="event_time" value="18:00 GMT" class="w-full px-4 py-3 rounded-xl bg-slate-900/90 border border-slate-800 text-white focus:border-teal-500 focus:outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-2">Lieu / Lien *</label>
                        <input type="text" name="location" value="En ligne / Zoom" required class="w-full px-4 py-3 rounded-xl bg-slate-900/90 border border-slate-800 text-white focus:border-teal-500 focus:outline-none text-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-2">Description complète *</label>
                    <textarea name="description" rows="3" required placeholder="Résumez les objectifs et prérequis de l'événement..." class="w-full px-4 py-3 rounded-xl bg-slate-900/90 border border-slate-800 text-white focus:border-teal-500 focus:outline-none text-sm leading-relaxed"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-2">Lien d'inscription (Facultatif)</label>
                    <input type="url" name="registration_url" placeholder="https://..." class="w-full px-4 py-3 rounded-xl bg-slate-900/90 border border-slate-800 text-white focus:border-teal-500 focus:outline-none text-sm">
                </div>

                <button type="submit" class="px-7 py-3 rounded-xl bg-gradient-to-r from-teal-500 to-emerald-500 hover:from-teal-400 hover:to-emerald-400 text-slate-950 font-extrabold text-xs shadow-glow-emerald transition-all">
                    <i class="fa-solid fa-paper-plane mr-2"></i> Publier l'Événement
                </button>
            </form>
        </div>
    </div>

    <!-- Events Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($events as $event)
            <div class="glass-card p-6 rounded-2xl border border-slate-800/80 space-y-4 hover:border-teal-500/40 transition-all shadow-xl">
                <div class="flex items-center justify-between">
                    <span class="px-3 py-1 rounded-full text-[10px] font-code uppercase font-bold bg-teal-500/20 text-teal-300 border border-teal-500/30">
                        {{ $event->type }}
                    </span>
                    <span class="text-xs font-code text-cyan-400 font-bold bg-cyan-950/60 px-3 py-1 rounded-full border border-cyan-500/30">
                        @if($event->event_date)
                            <i class="fa-regular fa-calendar-days mr-1.5 text-cyan-400"></i> {{ $event->event_date->format('d/m/Y') }}
                        @else
                            <i class="fa-regular fa-clock mr-1.5 text-amber-400"></i> À venir dans les plus brefs délais
                        @endif
                    </span>
                </div>

                <h3 class="text-base font-bold text-white font-display leading-snug">{{ $event->title }}</h3>
                <p class="text-xs text-slate-300 leading-relaxed">{{ Str::limit($event->description, 130) }}</p>
                @if($event->registration_url)
                    <a href="{{ $event->registration_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-xs font-bold text-emerald-400 hover:text-emerald-300">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i> Lien d’inscription
                    </a>
                @endif
                
                <!-- Admin Quick Date Assignment Panel -->
                <form method="POST" action="{{ route('admin.events.date', $event->id) }}" class="p-3.5 rounded-xl bg-slate-950/80 border border-slate-800/80 space-y-2">
                    @csrf
                    <label class="block text-[11px] font-code text-teal-400 font-bold flex items-center gap-1.5">
                        <i class="fa-solid fa-calendar-check text-xs"></i> Définir / Modifier la date
                    </label>
                    <div class="flex items-center gap-2">
                        <input type="date" name="event_date" value="{{ $event->event_date ? $event->event_date->format('Y-m-d') : '' }}" class="flex-1 px-3 py-2 rounded-xl bg-slate-900 border border-slate-800 text-white text-xs focus:border-teal-500 focus:outline-none">
                        <input type="text" name="event_time" value="{{ $event->event_time ?? '18:00 GMT' }}" placeholder="Heure" class="w-28 px-3 py-2 rounded-xl bg-slate-900 border border-slate-800 text-white text-xs focus:border-teal-500 focus:outline-none">
                        <button type="submit" class="px-3.5 py-2 rounded-xl bg-teal-500 hover:bg-teal-400 text-slate-950 font-bold text-xs transition-all shadow-glow-emerald">
                            Enregistrer
                        </button>
                    </div>
                </form>

                <div class="pt-3 border-t border-slate-800/80 flex items-center justify-between text-xs">
                    <span class="text-slate-400"><i class="fa-solid fa-location-dot mr-1.5 text-emerald-400"></i> {{ $event->location }}</span>
                    <form method="POST" action="{{ route('admin.events.delete', $event->id) }}" onsubmit="return confirm('Supprimer cet événement ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-rose-400 hover:text-rose-300 font-bold text-xs"><i class="fa-solid fa-trash mr-1"></i> Supprimer</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
