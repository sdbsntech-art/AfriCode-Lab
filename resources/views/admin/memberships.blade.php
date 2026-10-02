@extends('layouts.admin')

@section('title', 'Adhésions — Administration AfriCode Lab')
@section('header_title', 'Demandes d’adhésion')

@section('content')
<div class="space-y-7">
    <section class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#b85e32]">Communauté AfriCode Lab</p>
            <h2 class="mt-2 font-display text-2xl font-bold tracking-tight text-[#18382b] sm:text-3xl">Demandes d’adhésion</h2>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-[#68776a]">
                Consultez le profil, les coordonnées et la motivation de chaque professionnel, puis enregistrez votre décision.
            </p>
        </div>
        <span class="inline-flex w-fit items-center gap-2 rounded-full border border-[#d9ded5] bg-white px-4 py-2 text-sm font-semibold text-[#526258]">
            <i class="fa-solid fa-database text-[#b85e32]"></i>
            {{ $membershipStats['total'] }} demande{{ $membershipStats['total'] === 1 ? '' : 's' }} enregistrée{{ $membershipStats['total'] === 1 ? '' : 's' }}
        </span>
    </section>

    <section aria-label="État des adhésions" class="grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-[#e3e4dc] bg-white p-4">
            <p class="text-sm font-medium text-[#68776a]">Toutes les demandes</p>
            <p class="mt-2 font-display text-2xl font-bold text-[#18382b]">{{ $membershipStats['total'] }}</p>
        </div>
        <div class="rounded-2xl border border-[#eed9ca] bg-white p-4">
            <p class="text-sm font-medium text-[#8b624d]">En attente</p>
            <p class="mt-2 font-display text-2xl font-bold text-[#b85e32]">{{ $membershipStats['pending'] }}</p>
        </div>
        <div class="rounded-2xl border border-[#d9e5d9] bg-white p-4">
            <p class="text-sm font-medium text-[#68776a]">Acceptées</p>
            <p class="mt-2 font-display text-2xl font-bold text-[#1d4935]">{{ $membershipStats['approved'] }}</p>
        </div>
        <div class="rounded-2xl border border-[#ead8d3] bg-white p-4">
            <p class="text-sm font-medium text-[#80665e]">Refusées</p>
            <p class="mt-2 font-display text-2xl font-bold text-[#a44735]">{{ $membershipStats['rejected'] }}</p>
        </div>
    </section>

    <form method="GET" action="{{ route('admin.memberships') }}" class="grid gap-3 rounded-2xl border border-[#e3e4dc] bg-white p-4 sm:grid-cols-[minmax(0,1fr)_220px_auto]">
        <label class="relative">
            <span class="sr-only">Rechercher une demande</span>
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-[#8a9589]"></i>
            <input
                type="search"
                name="search"
                value="{{ $filters['search'] ?? '' }}"
                placeholder="Nom, e-mail ou téléphone"
                class="w-full rounded-xl border border-[#dfe3d8] bg-[#fcfbf7] py-3 pl-11 pr-4 text-sm text-[#18382b] outline-none placeholder:text-[#98a197] focus:border-[#1d4935] focus:ring-2 focus:ring-[#1d4935]/10"
            >
        </label>
        <label>
            <span class="sr-only">Filtrer par statut</span>
            <select name="status" class="w-full rounded-xl border border-[#dfe3d8] bg-[#fcfbf7] px-4 py-3 text-sm text-[#274535] outline-none focus:border-[#1d4935] focus:ring-2 focus:ring-[#1d4935]/10">
                <option value="">Tous les statuts</option>
                <option value="pending" @selected(($filters['status'] ?? '') === 'pending')>En attente</option>
                <option value="approved" @selected(($filters['status'] ?? '') === 'approved')>Acceptées</option>
                <option value="rejected" @selected(($filters['status'] ?? '') === 'rejected')>Refusées</option>
            </select>
        </label>
        <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#1d4935] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#143a29]">
            <i class="fa-solid fa-filter"></i>
            Filtrer
        </button>
    </form>

    <section class="space-y-4">
        @forelse($memberships as $membership)
            <article class="overflow-hidden rounded-2xl border border-[#e3e4dc] bg-white shadow-sm">
                <div class="grid gap-6 p-5 lg:grid-cols-[minmax(0,1fr)_minmax(260px,0.75fr)] lg:p-6">
                    <div class="space-y-5">
                        <div class="flex flex-wrap items-start justify-between gap-3">
                            <div class="flex min-w-0 items-center gap-3">
                                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-[#e8f0e8] font-display text-lg font-bold text-[#1d4935]">
                                    {{ strtoupper(substr($membership->name, 0, 1)) }}
                                </span>
                                <div class="min-w-0">
                                    <h3 class="truncate font-display text-lg font-bold text-[#18382b]">{{ $membership->name }}</h3>
                                    <p class="text-xs text-[#8a9589]">Demande reçue le {{ $membership->created_at?->format('d/m/Y à H:i') ?? 'Date non renseignée' }}</p>
                                </div>
                            </div>
                            <span class="rounded-full px-3 py-1.5 text-xs font-bold {{ $membership->status === 'approved' ? 'bg-[#e8f0e8] text-[#1d4935]' : ($membership->status === 'rejected' ? 'bg-[#f8e8e3] text-[#a44735]' : 'bg-[#fbefe7] text-[#a6522c]') }}">
                                {{ $membership->status === 'approved' ? 'Acceptée' : ($membership->status === 'rejected' ? 'Refusée' : 'En attente') }}
                            </span>
                        </div>

                        <dl class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <dt class="text-[11px] font-bold uppercase tracking-wider text-[#8a9589]">Adresse e-mail</dt>
                                <dd class="mt-1 break-all text-sm font-semibold text-[#274535]">
                                    <a href="mailto:{{ $membership->email }}" class="hover:text-[#b85e32]">{{ $membership->email }}</a>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-[11px] font-bold uppercase tracking-wider text-[#8a9589]">Téléphone</dt>
                                <dd class="mt-1 text-sm font-semibold text-[#274535]">{{ $membership->phone ?: 'Non renseigné' }}</dd>
                            </div>
                            <div>
                                <dt class="text-[11px] font-bold uppercase tracking-wider text-[#8a9589]">Type d’adhésion</dt>
                                <dd class="mt-1 text-sm font-semibold text-[#274535]">{{ \App\Models\Membership::TYPES[$membership->membership_type] ?? $membership->membership_type }}</dd>
                            </div>
                            <div>
                                <dt class="text-[11px] font-bold uppercase tracking-wider text-[#8a9589]">Expertise</dt>
                                <dd class="mt-1 text-sm font-semibold text-[#274535]">{{ $membership->expertise ?: 'Non précisée' }}</dd>
                            </div>
                        </dl>

                        <div class="rounded-xl bg-[#f8f7f1] p-4">
                            <h4 class="text-[11px] font-bold uppercase tracking-wider text-[#8a9589]">Motivation</h4>
                            <p class="mt-2 whitespace-pre-line break-words text-sm leading-6 text-[#405446]">{{ $membership->motivation }}</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.memberships.status', $membership) }}" class="flex flex-col gap-4 rounded-xl border border-[#e8e9e1] bg-[#fcfbf7] p-4">
                        @csrf
                        <div>
                            <label for="status-{{ $membership->id }}" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#68776a]">Décision</label>
                            <select id="status-{{ $membership->id }}" name="status" required class="w-full rounded-lg border border-[#dfe3d8] bg-white px-3 py-2.5 text-sm text-[#274535] outline-none focus:border-[#1d4935] focus:ring-2 focus:ring-[#1d4935]/10">
                                <option value="pending" @selected($membership->status === 'pending')>À examiner</option>
                                <option value="approved" @selected($membership->status === 'approved')>Accepter l’adhésion</option>
                                <option value="rejected" @selected($membership->status === 'rejected')>Refuser l’adhésion</option>
                            </select>
                        </div>
                        <div class="flex-1">
                            <label for="notes-{{ $membership->id }}" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#68776a]">Note interne</label>
                            <textarea id="notes-{{ $membership->id }}" name="admin_notes" rows="4" maxlength="5000" placeholder="Ajouter une note de suivi (facultatif)" class="w-full resize-y rounded-lg border border-[#dfe3d8] bg-white px-3 py-2.5 text-sm leading-5 text-[#274535] outline-none placeholder:text-[#98a197] focus:border-[#1d4935] focus:ring-2 focus:ring-[#1d4935]/10">{{ $membership->admin_notes }}</textarea>
                        </div>
                        @if($membership->reviewed_at)
                            <p class="text-xs text-[#78847a]">Dernier examen : {{ $membership->reviewed_at->format('d/m/Y à H:i') }}</p>
                        @endif
                        <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#1d4935] px-4 py-3 text-sm font-bold text-white transition hover:bg-[#143a29]">
                            <i class="fa-solid fa-floppy-disk"></i>
                            Enregistrer la décision
                        </button>
                    </form>
                </div>
            </article>
        @empty
            <div class="rounded-2xl border border-dashed border-[#ccd4c8] bg-white px-6 py-14 text-center">
                <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-[#f6f3eb] text-xl text-[#8a9589]"><i class="fa-regular fa-folder-open"></i></span>
                <h3 class="mt-4 font-display text-lg font-bold text-[#18382b]">Aucune demande trouvée</h3>
                <p class="mx-auto mt-2 max-w-lg text-sm leading-6 text-[#78847a]">
                    @if(($filters['search'] ?? '') !== '' || ($filters['status'] ?? '') !== '')
                        Essayez de modifier les filtres. Les demandes existantes restent enregistrées dans la base.
                    @else
                        Les demandes envoyées depuis le formulaire public « Adhérer à AfriCode Lab » apparaîtront ici.
                    @endif
                </p>
            </div>
        @endforelse

        @if($memberships->hasPages())
            <div class="rounded-xl border border-[#e3e4dc] bg-white px-4 py-3">
                {{ $memberships->links() }}
            </div>
        @endif
    </section>
</div>
@endsection
