@extends('layouts.dashboard')

@section('title', 'Mon Profil — AfriCode Lab')
@section('header_title', 'Mon Profil')

@section('content')
<div class="max-w-3xl mx-auto space-y-8">

    <!-- Profile Card Header -->
    <div class="glass-panel p-8 rounded-3xl border border-slate-700/80 flex flex-col sm:flex-row items-center gap-6 shadow-2xl">
        <div class="w-20 h-20 rounded-2xl bg-gradient-to-r from-cyan-500 via-emerald-400 to-purple-600 p-0.5 flex-shrink-0 shadow-neon">
            <div class="w-full h-full rounded-[14px] bg-slate-900 flex items-center justify-center text-3xl font-bold text-cyan-400 font-display">
                {{ strtoupper(substr($user->name, 0, 2)) }}
            </div>
        </div>
        <div class="space-y-1 text-center sm:text-left">
            <h2 class="text-2xl font-bold text-white font-display">{{ $user->name }}</h2>
            <p class="text-sm text-slate-400 font-code">{{ $user->email }}</p>
            <div class="flex items-center justify-center sm:justify-start gap-2 pt-1">
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-code uppercase font-bold bg-cyan-500/20 text-cyan-300 border border-cyan-500/30">
                    {{ $user->role }}
                </span>
                @if($user->specialization)
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-code uppercase font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                        {{ $user->specialization }}
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Profile Edit Form -->
    <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-slate-800 shadow-xl space-y-6">
        <h3 class="text-xl font-bold font-display text-white border-b border-slate-800 pb-4">Modifier mon profil</h3>

        <form method="POST" action="{{ route('dashboard.profile.update') }}" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-1.5">Nom Complet *</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 text-white focus:border-cyan-500 focus:outline-none text-sm">
                </div>

                <div>
                    <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-1.5">Adresse Email *</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 text-white focus:border-cyan-500 focus:outline-none text-sm">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-1.5">Téléphone</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 text-white focus:border-cyan-500 focus:outline-none text-sm">
                </div>

                <div>
                    <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-1.5">Spécialisation</label>
                    <input type="text" name="specialization" value="{{ old('specialization', $user->specialization) }}" class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 text-white focus:border-cyan-500 focus:outline-none text-sm">
                </div>
            </div>

            <div>
                <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-1.5">Biographie</label>
                <textarea name="bio" rows="3" class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 text-white focus:border-cyan-500 focus:outline-none text-sm">{{ old('bio', $user->bio) }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-1.5">Profil GitHub</label>
                    <input type="url" name="github_url" value="{{ old('github_url', $user->github_url) }}" class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 text-white focus:border-cyan-500 focus:outline-none text-sm">
                </div>

                <div>
                    <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-1.5">Profil LinkedIn</label>
                    <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $user->linkedin_url) }}" class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 text-white focus:border-cyan-500 focus:outline-none text-sm">
                </div>
            </div>

            <div class="pt-4 border-t border-slate-800 space-y-4">
                <h4 class="text-sm font-bold text-slate-300 font-code uppercase">Changer le mot de passe (optionnel)</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-1.5">Nouveau Mot de Passe</label>
                        <input type="password" name="password" class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 text-white focus:border-cyan-500 focus:outline-none text-sm" placeholder="Laisser vide pour conserver">
                    </div>

                    <div>
                        <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-1.5">Confirmer</label>
                        <input type="password" name="password_confirmation" class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 text-white focus:border-cyan-500 focus:outline-none text-sm" placeholder="••••••••">
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full py-3.5 rounded-xl bg-gradient-to-r from-cyan-400 via-emerald-400 to-teal-400 text-slate-950 font-extrabold text-sm shadow-neon hover:scale-[1.01] transition-all">
                <i class="fa-solid fa-save mr-2"></i> Sauvegarder les modifications
            </button>
        </form>
    </div>

</div>
@endsection
