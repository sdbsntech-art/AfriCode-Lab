@extends('layouts.admin')

@section('title', 'Administration — AfriCode Lab')
@section('header_title', 'Vue d’ensemble')

@section('content')
<div class="space-y-8">
    <section class="relative overflow-hidden rounded-[2rem] bg-[#1d4935] px-6 py-8 text-white shadow-xl shadow-[#18382b]/10 sm:px-9 sm:py-10">
        <div class="pointer-events-none absolute -right-16 -top-24 h-72 w-72 rounded-full border border-white/10"></div>
        <div class="pointer-events-none absolute -right-2 -top-10 h-48 w-48 rounded-full bg-[#d87842]/20 blur-3xl"></div>
        <div class="relative flex flex-col justify-between gap-7 sm:flex-row sm:items-end">
            <div class="max-w-2xl space-y-4">
                <span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1.5 text-xs font-semibold text-[#f2d7c4]">
                    <i class="fa-solid fa-earth-africa"></i>
                    Espace de pilotage
                </span>
                <h2 class="font-display text-3xl font-bold tracking-tight sm:text-4xl">
                    Bienvenue, {{ auth()->user()->name }}
                </h2>
                <p class="max-w-xl text-sm leading-6 text-white/75 sm:text-base">
                    Suivez les adhésions, les candidatures et les contributions qui font avancer la vision numérique africaine.
                </p>
            </div>
            <a href="{{ route('admin.memberships') }}" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-full bg-[#f6f3eb] px-5 py-3 text-sm font-bold text-[#1d4935] transition hover:-translate-y-0.5 hover:bg-white">
                <i class="fa-solid fa-inbox text-[#b85e32]"></i>
                Examiner les demandes
            </a>
        </div>
    </section>

    <section aria-label="Statistiques réelles" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <article class="rounded-2xl border border-[#e3e4dc] bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold text-[#68776a]">Demandes au total</p>
                    <p class="mt-3 font-display text-3xl font-bold text-[#18382b]">{{ $stats['memberships_total'] }}</p>
                </div>
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#e8f0e8] text-[#1d4935]"><i class="fa-solid fa-people-group"></i></span>
            </div>
            <p class="mt-4 border-t border-[#edf0e9] pt-3 text-xs text-[#78847a]">Demandes réelles enregistrées</p>
        </article>

        <article class="rounded-2xl border border-[#eed9ca] bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold text-[#8b624d]">Adhésions à traiter</p>
                    <p class="mt-3 font-display text-3xl font-bold text-[#b85e32]">{{ $stats['memberships_pending'] }}</p>
                </div>
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#fbefe7] text-[#b85e32]"><i class="fa-solid fa-hourglass-half"></i></span>
            </div>
            <p class="mt-4 border-t border-[#f4e8df] pt-3 text-xs text-[#8b7569]">Demandes en attente de décision</p>
        </article>

        <article class="rounded-2xl border border-[#e3e4dc] bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold text-[#68776a]">Candidatures à examiner</p>
                    <p class="mt-3 font-display text-3xl font-bold text-[#18382b]">{{ $stats['applications_pending'] }}</p>
                </div>
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#f1eee2] text-[#9b773d]"><i class="fa-solid fa-file-signature"></i></span>
            </div>
            <p class="mt-4 border-t border-[#edf0e9] pt-3 text-xs text-[#78847a]">Contributions et profils professionnels</p>
        </article>

        <article class="rounded-2xl border border-[#d9e5d9] bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold text-[#68776a]">Membres validés</p>
                    <p class="mt-3 font-display text-3xl font-bold text-[#1d4935]">{{ $stats['memberships_approved'] }}</p>
                </div>
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#e8f0e8] text-[#1d4935]"><i class="fa-solid fa-user-check"></i></span>
            </div>
            <p class="mt-4 border-t border-[#edf0e9] pt-3 text-xs text-[#78847a]">Adhésions acceptées dans la base</p>
        </article>
    </section>

    <section class="grid gap-6 xl:grid-cols-[minmax(0,0.85fr)_minmax(0,1.15fr)]">
        <div class="rounded-2xl border border-[#d9e5d9] bg-white p-5 shadow-sm sm:p-6">
            <div class="flex items-start gap-3">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#e8f0e8] text-[#1d4935]">
                    <i class="fa-solid fa-calendar-plus"></i>
                </span>
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#b85e32]">Planifier</p>
                    <h3 class="mt-1 font-display text-xl font-bold text-[#18382b]">Un événement ou hackathon</h3>
                    <p class="mt-2 text-sm leading-6 text-[#68776a]">Ajoutez le programme, la date, le lieu et les informations d’inscription.</p>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.events.store') }}" class="mt-6 space-y-4">
                @csrf
                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="event-title" class="mb-1.5 block text-xs font-bold text-[#526258]">Nom de l’événement *</label>
                        <input id="event-title" type="text" name="title" value="{{ old('title') }}" required maxlength="255" placeholder="Ex. Hackathon AfriCode Lab" class="w-full rounded-xl border border-[#dfe3d8] bg-[#fcfbf7] px-3.5 py-3 text-sm text-[#18382b] outline-none placeholder:text-[#98a197] focus:border-[#1d4935] focus:ring-2 focus:ring-[#1d4935]/10">
                        @error('title') <p class="mt-1 text-xs text-[#a44735]">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="event-type" class="mb-1.5 block text-xs font-bold text-[#526258]">Type *</label>
                        <select id="event-type" name="type" required class="w-full rounded-xl border border-[#dfe3d8] bg-[#fcfbf7] px-3.5 py-3 text-sm text-[#274535] outline-none focus:border-[#1d4935] focus:ring-2 focus:ring-[#1d4935]/10">
                            <option value="Webinaire" @selected(old('type') === 'Webinaire')>Webinaire</option>
                            <option value="Atelier" @selected(old('type') === 'Atelier')>Atelier</option>
                            <option value="Hackathon" @selected(old('type') === 'Hackathon')>Hackathon</option>
                            <option value="Conférence" @selected(old('type') === 'Conférence')>Conférence</option>
                        </select>
                    </div>
                    <div>
                        <label for="event-date" class="mb-1.5 block text-xs font-bold text-[#526258]">Date</label>
                        <input id="event-date" type="date" name="event_date" value="{{ old('event_date') }}" min="{{ today()->toDateString() }}" class="w-full rounded-xl border border-[#dfe3d8] bg-[#fcfbf7] px-3.5 py-3 text-sm text-[#274535] outline-none focus:border-[#1d4935] focus:ring-2 focus:ring-[#1d4935]/10">
                        @error('event_date') <p class="mt-1 text-xs text-[#a44735]">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="event-time" class="mb-1.5 block text-xs font-bold text-[#526258]">Heure (GMT)</label>
                        <input id="event-time" type="text" name="event_time" value="{{ old('event_time', '18:00 GMT') }}" maxlength="50" placeholder="18:00 GMT" class="w-full rounded-xl border border-[#dfe3d8] bg-[#fcfbf7] px-3.5 py-3 text-sm text-[#274535] outline-none focus:border-[#1d4935] focus:ring-2 focus:ring-[#1d4935]/10">
                    </div>
                    <div>
                        <label for="event-location" class="mb-1.5 block text-xs font-bold text-[#526258]">Lieu ou plateforme *</label>
                        <input id="event-location" type="text" name="location" value="{{ old('location', 'En ligne / Zoom') }}" required maxlength="255" placeholder="En ligne, Dakar…" class="w-full rounded-xl border border-[#dfe3d8] bg-[#fcfbf7] px-3.5 py-3 text-sm text-[#274535] outline-none focus:border-[#1d4935] focus:ring-2 focus:ring-[#1d4935]/10">
                        @error('location') <p class="mt-1 text-xs text-[#a44735]">{{ $message }}</p> @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label for="event-registration-url" class="mb-1.5 block text-xs font-bold text-[#526258]">Lien d’inscription (facultatif)</label>
                        <input id="event-registration-url" type="url" name="registration_url" value="{{ old('registration_url') }}" maxlength="255" placeholder="https://…" class="w-full rounded-xl border border-[#dfe3d8] bg-[#fcfbf7] px-3.5 py-3 text-sm text-[#274535] outline-none placeholder:text-[#98a197] focus:border-[#1d4935] focus:ring-2 focus:ring-[#1d4935]/10">
                        @error('registration_url') <p class="mt-1 text-xs text-[#a44735]">{{ $message }}</p> @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label for="event-description" class="mb-1.5 block text-xs font-bold text-[#526258]">Description et informations pratiques *</label>
                        <textarea id="event-description" name="description" rows="3" required maxlength="5000" placeholder="Objectifs, programme, public concerné, modalités…" class="w-full resize-y rounded-xl border border-[#dfe3d8] bg-[#fcfbf7] px-3.5 py-3 text-sm leading-6 text-[#274535] outline-none placeholder:text-[#98a197] focus:border-[#1d4935] focus:ring-2 focus:ring-[#1d4935]/10">{{ old('description') }}</textarea>
                        @error('description') <p class="mt-1 text-xs text-[#a44735]">{{ $message }}</p> @enderror
                    </div>
                </div>
                <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-[#1d4935] px-5 py-3.5 text-sm font-bold text-white transition hover:bg-[#143a29] sm:w-auto">
                    <i class="fa-solid fa-calendar-check"></i>
                    Ajouter au calendrier
                </button>
            </form>
        </div>

        <div class="overflow-hidden rounded-2xl border border-[#e3e4dc] bg-white shadow-sm">
            <div class="flex flex-col justify-between gap-3 border-b border-[#edf0e9] px-5 py-5 sm:flex-row sm:items-center sm:px-6">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#b85e32]">Calendrier AfriCode Lab</p>
                    <h3 class="mt-1 font-display text-xl font-bold text-[#18382b]">À venir et à programmer</h3>
                </div>
                <a href="{{ route('admin.events') }}" class="inline-flex items-center gap-2 text-sm font-bold text-[#1d4935] hover:text-[#b85e32]">
                    Gérer l’agenda <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>

            @forelse($upcomingEvents as $event)
                <article class="border-b border-[#edf0e9] px-5 py-5 last:border-b-0 sm:px-6">
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div class="min-w-0">
                            <span class="inline-flex rounded-full px-2.5 py-1 text-[11px] font-bold {{ $event->type === 'Hackathon' ? 'bg-[#fbefe7] text-[#a6522c]' : 'bg-[#e8f0e8] text-[#1d4935]' }}">
                                {{ $event->type }}
                            </span>
                            <h4 class="mt-2 break-words font-display font-bold text-[#18382b]">{{ $event->title }}</h4>
                            <p class="mt-1 text-xs text-[#68776a]">
                                <i class="fa-solid fa-location-dot mr-1 text-[#b85e32]"></i>{{ $event->location }}
                                @if($event->event_date)
                                    <span class="px-1">·</span>{{ $event->event_date->format('d/m/Y') }}
                                @else
                                    <span class="px-1">·</span><span class="font-semibold text-[#a6522c]">Date à programmer</span>
                                @endif
                                @if($event->event_time)
                                    <span class="px-1">·</span>{{ $event->event_time }}
                                @endif
                            </p>
                        </div>
                        @if($event->registration_url)
                            <a href="{{ $event->registration_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#1d4935] hover:text-[#b85e32]">
                                Inscription <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            </a>
                        @endif
                    </div>
                    <p class="mt-3 text-sm leading-6 text-[#526258]">{{ \Illuminate\Support\Str::limit($event->description, 160) }}</p>

                    <form method="POST" action="{{ route('admin.events.date', $event) }}" class="mt-4 grid gap-2 rounded-xl bg-[#f8f7f1] p-3 sm:grid-cols-[minmax(0,1fr)_minmax(0,0.8fr)_auto]">
                        @csrf
                        <label class="sr-only" for="date-{{ $event->id }}">Date de {{ $event->title }}</label>
                        <input id="date-{{ $event->id }}" type="date" name="event_date" value="{{ $event->event_date?->format('Y-m-d') }}" min="{{ today()->toDateString() }}" class="min-w-0 rounded-lg border border-[#dfe3d8] bg-white px-3 py-2.5 text-xs text-[#274535] outline-none focus:border-[#1d4935] focus:ring-2 focus:ring-[#1d4935]/10">
                        <label class="sr-only" for="time-{{ $event->id }}">Heure de {{ $event->title }}</label>
                        <input id="time-{{ $event->id }}" type="text" name="event_time" value="{{ $event->event_time }}" maxlength="50" placeholder="Heure (GMT)" class="min-w-0 rounded-lg border border-[#dfe3d8] bg-white px-3 py-2.5 text-xs text-[#274535] outline-none focus:border-[#1d4935] focus:ring-2 focus:ring-[#1d4935]/10">
                        <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#e8f0e8] px-3 py-2.5 text-xs font-bold text-[#1d4935] transition hover:bg-[#d9e5d9]">
                            <i class="fa-solid fa-floppy-disk"></i> Enregistrer
                        </button>
                    </form>
                </article>
            @empty
                <div class="px-6 py-12 text-center">
                    <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-[#f6f3eb] text-[#8a9589]"><i class="fa-regular fa-calendar"></i></span>
                    <p class="mt-4 font-semibold text-[#18382b]">Aucun événement à venir</p>
                    <p class="mt-1 text-sm text-[#78847a]">Planifiez une rencontre, un atelier ou un hackathon avec le formulaire.</p>
                </div>
            @endforelse
        </div>
    </section>

    <section class="overflow-hidden rounded-2xl border border-[#e3e4dc] bg-white shadow-sm">
        <div class="flex flex-col justify-between gap-4 border-b border-[#edf0e9] px-5 py-5 sm:flex-row sm:items-center sm:px-6">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#b85e32]">À examiner en priorité</p>
                <h3 class="mt-1 font-display text-xl font-bold text-[#18382b]">Demandes d’adhésion récentes</h3>
            </div>
            <a href="{{ route('admin.memberships') }}" class="inline-flex items-center gap-2 text-sm font-bold text-[#1d4935] hover:text-[#b85e32]">
                Toutes les demandes <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        @forelse($recentMemberships as $membership)
            <div class="flex flex-col gap-4 border-b border-[#edf0e9] px-5 py-5 last:border-b-0 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                <div class="flex min-w-0 items-start gap-3">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-[#e8f0e8] font-display font-bold text-[#1d4935]">
                        {{ strtoupper(substr($membership->name, 0, 1)) }}
                    </span>
                    <div class="min-w-0">
                        <p class="truncate font-bold text-[#18382b]">{{ $membership->name }}</p>
                        <p class="mt-1 break-all text-sm text-[#68776a]">{{ $membership->email }}{{ $membership->phone ? ' · '.$membership->phone : '' }}</p>
                        <p class="mt-1 text-xs text-[#8a9589]">
                            {{ \App\Models\Membership::TYPES[$membership->membership_type] ?? $membership->membership_type }}
                            · {{ $membership->created_at?->format('d/m/Y') ?? 'Date non renseignée' }}
                        </p>
                    </div>
                </div>
                <span class="w-fit rounded-full px-3 py-1.5 text-xs font-bold {{ $membership->status === 'approved' ? 'bg-[#e8f0e8] text-[#1d4935]' : ($membership->status === 'rejected' ? 'bg-[#f8e8e3] text-[#a44735]' : 'bg-[#fbefe7] text-[#a6522c]') }}">
                    {{ $membership->status === 'approved' ? 'Acceptée' : ($membership->status === 'rejected' ? 'Refusée' : 'En attente') }}
                </span>
            </div>
        @empty
            <div class="px-6 py-12 text-center">
                <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-[#f6f3eb] text-[#8a9589]"><i class="fa-regular fa-folder-open"></i></span>
                <p class="mt-4 font-semibold text-[#18382b]">Aucune demande d’adhésion pour le moment</p>
                <p class="mt-1 text-sm text-[#78847a]">Les nouvelles demandes envoyées depuis le site apparaîtront ici.</p>
            </div>
        @endforelse
    </section>

    <section class="grid gap-6 lg:grid-cols-2">
        <div class="overflow-hidden rounded-2xl border border-[#e3e4dc] bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-[#edf0e9] px-5 py-4">
                <h3 class="font-display font-bold text-[#18382b]">Candidatures récentes</h3>
                <a href="{{ route('admin.applications') }}" class="text-sm font-bold text-[#1d4935] hover:text-[#b85e32]">Voir tout</a>
            </div>
            @forelse($recentApplications as $application)
                <div class="flex items-center justify-between gap-4 border-b border-[#edf0e9] px-5 py-4 last:border-b-0">
                    <div class="min-w-0">
                        <p class="truncate text-sm font-bold text-[#18382b]">{{ $application->name }}</p>
                        <p class="mt-1 truncate text-xs text-[#78847a]">{{ $application->email }} · {{ $application->role_applied }}</p>
                    </div>
                    <span class="shrink-0 rounded-full px-2.5 py-1 text-[11px] font-bold {{ $application->status === 'approved' ? 'bg-[#e8f0e8] text-[#1d4935]' : ($application->status === 'rejected' ? 'bg-[#f8e8e3] text-[#a44735]' : 'bg-[#fbefe7] text-[#a6522c]') }}">
                        {{ $application->status === 'approved' ? 'Acceptée' : ($application->status === 'rejected' ? 'Refusée' : 'En attente') }}
                    </span>
                </div>
            @empty
                <p class="px-5 py-8 text-sm text-[#78847a]">Aucune candidature enregistrée.</p>
            @endforelse
        </div>

        <div class="rounded-2xl border border-[#dfe3d8] bg-[#eeeee4] p-5 sm:p-6">
            <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#b85e32]">Raccourcis</p>
            <h3 class="mt-2 font-display text-xl font-bold text-[#18382b]">Organiser les prochaines actions</h3>
            <div class="mt-5 grid gap-3 sm:grid-cols-2">
                <a href="{{ route('admin.memberships') }}" class="flex items-center gap-3 rounded-xl border border-[#d9ded5] bg-white p-4 font-semibold text-[#274535] transition hover:border-[#1d4935]">
                    <i class="fa-solid fa-people-group text-[#b85e32]"></i> Gérer les adhésions
                </a>
                <a href="{{ route('admin.applications') }}" class="flex items-center gap-3 rounded-xl border border-[#d9ded5] bg-white p-4 font-semibold text-[#274535] transition hover:border-[#1d4935]">
                    <i class="fa-solid fa-file-signature text-[#b85e32]"></i> Voir les candidatures
                </a>
                <a href="{{ route('admin.events') }}" class="flex items-center gap-3 rounded-xl border border-[#d9ded5] bg-white p-4 font-semibold text-[#274535] transition hover:border-[#1d4935]">
                    <i class="fa-solid fa-calendar-days text-[#b85e32]"></i> Organiser l’agenda
                </a>
                <a href="{{ route('admin.projects') }}" class="flex items-center gap-3 rounded-xl border border-[#d9ded5] bg-white p-4 font-semibold text-[#274535] transition hover:border-[#1d4935]">
                    <i class="fa-solid fa-lightbulb text-[#b85e32]"></i> Suivre les projets
                </a>
            </div>
        </div>
    </section>
</div>
@endsection
