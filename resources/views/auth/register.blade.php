@extends('layouts.app')

@section('title', 'Inscription — AfriCode Lab')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-grid-pattern">
    <div class="max-w-xl w-full glass-panel p-8 sm:p-10 rounded-3xl border border-slate-700/80 shadow-2xl space-y-6">
        
        <div class="text-center space-y-2">
            <div class="w-14 h-14 rounded-2xl overflow-hidden p-0.5 bg-gradient-to-r from-cyan-500 via-emerald-400 to-purple-600 shadow-neon mx-auto">
                <img src="{{ asset('images/logo.jpeg') }}" alt="AfriCode Lab Logo" class="w-full h-full object-cover rounded-[14px]">
            </div>
            <h1 class="text-2xl font-bold font-display text-white">Rejoignez AfriCode Lab</h1>
            <p class="text-xs text-slate-400">Inscrivez-vous gratuitement pour développer vos compétences numériques</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-1.5">Nom & Prénom *</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 text-white focus:border-cyan-500 focus:outline-none text-sm" placeholder="ex: Amina Diallo">
            </div>

            <div>
                <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-1.5">Adresse Email *</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 text-white focus:border-cyan-500 focus:outline-none text-sm" placeholder="amina@example.com">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-1.5">Spécialité d'intérêt</label>
                    <select name="specialization" class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 text-white focus:border-cyan-500 focus:outline-none text-sm">
                        <option value="Développement & Programmation">Développement & Programmation</option>
                        <option value="Cybersécurité">Cybersécurité</option>
                        <option value="Data & Intelligence Artificielle">Data & Intelligence Artificielle</option>
                        <option value="Réseaux & Infrastructures">Réseaux & Infrastructures</option>
                        <option value="DevOps & Cloud">DevOps & Cloud</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-1.5">Téléphone / WhatsApp</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 text-white focus:border-cyan-500 focus:outline-none text-sm" placeholder="+221 77 000 00 00">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-1.5">Mot de Passe *</label>
                    <input type="password" name="password" required class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 text-white focus:border-cyan-500 focus:outline-none text-sm" placeholder="••••••••">
                </div>

                <div>
                    <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-1.5">Confirmer le Mot de Passe *</label>
                    <input type="password" name="password_confirmation" required class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 text-white focus:border-cyan-500 focus:outline-none text-sm" placeholder="••••••••">
                </div>
            </div>

            <button type="submit" class="w-full py-3.5 rounded-xl bg-gradient-to-r from-cyan-400 via-emerald-400 to-teal-400 text-slate-950 font-extrabold text-sm shadow-neon hover:scale-[1.01] transition-all">
                Créer Mon Compte Apprenant
            </button>
        </form>

        <div class="relative py-1">
            <div class="absolute inset-0 flex items-center" aria-hidden="true"><div class="w-full border-t border-slate-800"></div></div>
            <div class="relative flex justify-center"><span class="bg-slate-950 px-3 text-xs text-slate-400">ou créer un compte avec</span></div>
        </div>

        <a href="{{ route('auth.google.redirect') }}" class="flex w-full items-center justify-center gap-3 rounded-xl border border-slate-700 bg-white px-4 py-3 text-sm font-bold text-slate-800 transition hover:bg-slate-100">
            <svg class="h-5 w-5" viewBox="0 0 48 48" aria-hidden="true">
                <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.73 7.18l7.64 5.93c4.46-4.12 7.13-10.18 7.13-17.58z"/>
                <path fill="#FBBC05" d="M10.53 28.59a14.4 14.4 0 0 1 0-9.18l-7.98-6.19a23.9 23.9 0 0 0 0 21.56l7.98-6.19z"/>
                <path fill="#34A853" d="M24 48c6.47 0 11.91-2.13 15.88-5.87l-7.64-5.93c-2.12 1.42-4.84 2.27-8.24 2.27-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
            </svg>
            Continuer avec Google
        </a>

        <div class="text-center text-xs text-slate-400 pt-2 border-t border-slate-800">
            Vous possédez déjà un compte ?
            <a href="{{ route('login') }}" class="text-cyan-400 font-bold hover:underline ml-1">Se connecter</a>
        </div>

    </div>
</div>
@endsection
