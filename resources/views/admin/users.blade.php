@extends('layouts.admin')

@section('title', 'Gestion Utilisateurs — Admin AfriCode Lab')
@section('header_title', 'Gestion des Utilisateurs')

@section('content')
<div class="space-y-6">

    <!-- Header Actions & Filters Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 glass-card p-4 rounded-2xl border border-slate-800/80">
        <div class="flex items-center gap-2">
            <span class="text-xs font-code uppercase font-bold text-slate-400 mr-2">Filtrer par Rôle :</span>
            <a href="{{ route('admin.users') }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ !request('role') ? 'bg-gradient-to-r from-emerald-500 to-teal-500 text-slate-950 shadow-glow-emerald' : 'bg-slate-800/60 text-slate-300 hover:text-white' }}">Tous</a>
            <a href="{{ route('admin.users', ['role' => 'student']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ request('role') === 'student' ? 'bg-cyan-500 text-slate-950 shadow-glow-cyan' : 'bg-slate-800/60 text-slate-300 hover:text-white' }}">Étudiants</a>
            <a href="{{ route('admin.users', ['role' => 'trainer']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ request('role') === 'trainer' ? 'bg-emerald-500 text-slate-950 shadow-glow-emerald' : 'bg-slate-800/60 text-slate-300 hover:text-white' }}">Formateurs</a>
            <a href="{{ route('admin.users', ['role' => 'admin']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ request('role') === 'admin' ? 'bg-purple-500 text-white shadow-glow-purple' : 'bg-slate-800/60 text-slate-300 hover:text-white' }}">Admins</a>
        </div>

        <form method="GET" action="{{ route('admin.users') }}" class="flex items-center gap-2">
            @if(request('role')) <input type="hidden" name="role" value="{{ request('role') }}"> @endif
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher nom/email..." class="pl-9 pr-4 py-2 rounded-xl bg-slate-900/90 border border-slate-800 text-white text-xs focus:border-emerald-500 focus:outline-none w-48 sm:w-64">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-slate-500 text-xs"></i>
            </div>
            <button type="submit" class="px-3.5 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-white text-xs font-bold">Filtrer</button>
        </form>
    </div>

    <!-- Users Table Card -->
    <div class="glass-card rounded-2xl border border-slate-800/80 overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-950/60 border-b border-slate-800/80 text-slate-400 uppercase font-code">
                    <tr>
                        <th class="px-6 py-4">Utilisateur</th>
                        <th class="px-4 py-4">Adresse Email</th>
                        <th class="px-4 py-4">Rôle</th>
                        <th class="px-4 py-4">Spécialisation</th>
                        <th class="text-center px-4 py-4">Compte Active</th>
                        <th class="text-right px-6 py-4">Identifiant</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @foreach($users as $user)
                        <tr class="hover:bg-slate-800/40 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($user->avatar)
                                        <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-9 h-9 rounded-xl object-cover border border-slate-700">
                                    @else
                                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-500/20 to-cyan-500/20 border border-emerald-500/30 flex items-center justify-center text-emerald-400 font-bold font-display text-xs">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-bold text-white text-xs flex items-center gap-1.5">
                                            {{ $user->name }}
                                            @if($user->google_id)
                                                <i class="fa-brands fa-google text-[10px] text-cyan-400" title="Connecté via Google"></i>
                                            @endif
                                        </p>
                                        <p class="text-[10px] text-slate-400 font-code">Inscrit le {{ $user->created_at->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-slate-300 font-code">{{ $user->email }}</td>
                            <td class="px-4 py-4">
                                <form method="POST" action="{{ route('admin.users.role', $user->id) }}" class="inline">
                                    @csrf
                                    <select name="role" onchange="this.form.submit()" class="bg-slate-900/90 border border-slate-700/80 rounded-xl text-xs py-1.5 px-3 text-white focus:border-emerald-500 focus:outline-none cursor-pointer">
                                        <option value="student" {{ $user->role === 'student' ? 'selected' : '' }}>Étudiant</option>
                                        <option value="trainer" {{ $user->role === 'trainer' ? 'selected' : '' }}>Formateur</option>
                                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrateur</option>
                                    </select>
                                </form>
                            </td>
                            <td class="px-4 py-4 text-slate-400">{{ $user->specialization ?? 'Général' }}</td>
                            <td class="px-4 py-4 text-center">
                                <form method="POST" action="{{ route('admin.users.status', $user->id) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 rounded-full text-[10px] font-code font-bold transition-all {{ $user->is_active ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 hover:bg-rose-500/20 hover:text-rose-300 hover:border-rose-500/30' : 'bg-rose-500/20 text-rose-300 border border-rose-500/30 hover:bg-emerald-500/20 hover:text-emerald-300' }}">
                                        <i class="fa-solid {{ $user->is_active ? 'fa-circle-check text-emerald-400' : 'fa-circle-xmark text-rose-400' }} mr-1"></i>
                                        {{ $user->is_active ? 'Actif' : 'Désactivé' }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4 text-right font-code text-slate-400">
                                <span class="px-2 py-1 bg-slate-900 rounded-md border border-slate-800 text-[10px]">#{{ $user->id }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="flex justify-center pt-2">
        {{ $users->links() }}
    </div>

</div>
@endsection
