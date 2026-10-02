@extends('layouts.admin')

@section('title', 'Gestion Candidatures — Admin AfriCode Lab')
@section('header_title', 'Gestion des Candidatures Formateurs & Mentors')

@section('content')
<div class="space-y-6">

    <!-- Header Card -->
    <div class="glass-card p-6 rounded-2xl border border-slate-800/80 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold font-display text-white flex items-center gap-2">
                <i class="fa-solid fa-id-card text-rose-400"></i> Candidatures Recues ({{ $applications->count() }})
            </h2>
            <p class="text-xs text-slate-400 mt-1">Examinez les demandes de professionnels souhaitant intervenir comme mentors ou formateurs.</p>
        </div>
    </div>

    <!-- Applications Table -->
    <div class="glass-card rounded-2xl border border-slate-800/80 overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-950/60 border-b border-slate-800/80 text-slate-400 uppercase font-code">
                    <tr>
                        <th class="px-6 py-4">Candidat</th>
                        <th class="px-4 py-4">Rôle Souhaité</th>
                        <th class="px-4 py-4">Domaine d'Expertise</th>
                        <th class="px-4 py-4">Expérience</th>
                        <th class="text-center px-4 py-4">Statut actuel</th>
                        <th class="text-right px-6 py-4">Décision Admin</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @foreach($applications as $app)
                        <tr class="hover:bg-slate-800/40 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-bold text-white text-xs">{{ $app->name }}</p>
                                <p class="text-[11px] text-slate-400 font-code">{{ $app->email }} · {{ $app->phone ?? 'Tel non renseigné' }}</p>
                            </td>
                            <td class="px-4 py-4"><span class="px-2.5 py-1 rounded-full bg-cyan-500/10 text-cyan-300 border border-cyan-500/30 font-bold font-code text-[10px]">{{ $app->role_applied }}</span></td>
                            <td class="px-4 py-4 text-slate-300 font-medium">{{ $app->domain_expertise }}</td>
                            <td class="px-4 py-4 text-slate-400">{{ $app->experience_years }}</td>
                            <td class="px-4 py-4 text-center">
                                <span class="px-3 py-1 rounded-full text-[10px] font-code uppercase font-bold {{ $app->status === 'approved' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : ($app->status === 'rejected' ? 'bg-rose-500/20 text-rose-300 border border-rose-500/30' : 'bg-amber-500/20 text-amber-300 border border-amber-500/30 animate-pulse') }}">
                                    {{ $app->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <form method="POST" action="{{ route('admin.applications.status', $app->id) }}" class="inline">
                                        @csrf
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" title="Approuver le candidat" class="px-3 py-1.5 rounded-lg bg-emerald-500/15 text-emerald-400 hover:bg-emerald-500/30 border border-emerald-500/30 font-bold transition-all text-xs flex items-center gap-1">
                                            <i class="fa-solid fa-check text-xs"></i> Approuver
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.applications.status', $app->id) }}" class="inline">
                                        @csrf
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" title="Refuser le candidat" class="px-3 py-1.5 rounded-lg bg-rose-500/15 text-rose-400 hover:bg-rose-500/30 border border-rose-500/30 font-bold transition-all text-xs flex items-center gap-1">
                                            <i class="fa-solid fa-xmark text-xs"></i> Refuser
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
