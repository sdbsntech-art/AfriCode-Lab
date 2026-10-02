@extends('layouts.app')

@section('title', 'Nouveau Mot de Passe — AfriCode Lab')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-grid-pattern">
    <div class="max-w-md w-full glass-panel p-8 sm:p-10 rounded-3xl border border-slate-700/80 shadow-2xl space-y-6">
        
        <div class="text-center space-y-2">
            <h1 class="text-2xl font-bold font-display text-white">Nouveau Mot de Passe</h1>
            <p class="text-xs text-slate-400">Définissez votre nouveau mot de passe sécurisé</p>
        </div>

        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-2">Adresse Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 text-white focus:border-cyan-500 focus:outline-none text-sm">
            </div>

            <div>
                <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-2">Nouveau Mot de Passe</label>
                <input type="password" name="password" required class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 text-white focus:border-cyan-500 focus:outline-none text-sm" placeholder="••••••••">
            </div>

            <div>
                <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-2">Confirmer le Mot de Passe</label>
                <input type="password" name="password_confirmation" required class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 text-white focus:border-cyan-500 focus:outline-none text-sm" placeholder="••••••••">
            </div>

            <button type="submit" class="w-full py-3.5 rounded-xl bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-bold text-sm transition-all shadow-neon">
                Réinitialiser le mot de passe
            </button>
        </form>

    </div>
</div>
@endsection
