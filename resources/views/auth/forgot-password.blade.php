@extends('layouts.app')

@section('title', 'Mot de Passe Oublié — AfriCode Lab')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-grid-pattern">
    <div class="max-w-md w-full glass-panel p-8 sm:p-10 rounded-3xl border border-slate-700/80 shadow-2xl space-y-6">
        
        <div class="text-center space-y-2">
            <h1 class="text-2xl font-bold font-display text-white">Réinitialisation du Mot de Passe</h1>
            <p class="text-xs text-slate-400">Entrez votre email pour recevoir les instructions</p>
        </div>

        @if (session('status'))
            <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-xs font-medium">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-2">Adresse Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 text-white focus:border-cyan-500 focus:outline-none text-sm" placeholder="votre.email@example.com">
            </div>

            <button type="submit" class="w-full py-3.5 rounded-xl bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-bold text-sm transition-all shadow-neon">
                Envoyer le lien de réinitialisation
            </button>
        </form>

        <div class="text-center text-xs text-slate-400 pt-2 border-t border-slate-800">
            <a href="{{ route('login') }}" class="text-cyan-400 hover:underline"><i class="fa-solid fa-arrow-left mr-1"></i> Retour à la connexion</a>
        </div>

    </div>
</div>
@endsection
