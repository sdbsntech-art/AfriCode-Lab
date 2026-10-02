@extends('layouts.app')

@section('title', 'Contact — AfriCode Lab')

@section('content')
<div class="py-16 bg-grid-pattern">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-3xl mx-auto mb-16 space-y-4">
            <span class="px-3 py-1 rounded-full text-xs font-code font-bold uppercase bg-cyan-500/10 text-cyan-400 border border-cyan-500/30">
                Discutons Ensemble
            </span>
            <h1 class="text-4xl sm:text-5xl font-extrabold font-display text-white">
                Contactez l'Équipe AfriCode Lab
            </h1>
            <p class="text-slate-300 text-base">
                Vous avez des questions sur nos formations, nos événements ou nos partenariats ?
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            
            <div class="lg:col-span-5 space-y-6">
                <div class="glass-panel p-6 rounded-2xl border border-slate-800 space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-cyan-500/20 text-cyan-400 flex items-center justify-center font-bold">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <h4 class="font-bold text-white text-base">Email Officiel</h4>
                    <p class="text-xs text-slate-300">contact@africodelab.org</p>
                    <p class="text-xs text-slate-300">support@africodelab.org</p>
                </div>

                <div class="glass-panel p-6 rounded-2xl border border-slate-800 space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <h4 class="font-bold text-white text-base">Réseau Panafricain</h4>
                    <p class="text-xs text-slate-300">Hub Dakar, Sénégal & Hubs Partenaires (Abidjan, Lomé, Yaoundé)</p>
                </div>

                <div class="glass-panel p-6 rounded-2xl border border-slate-800 space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-purple-500/20 text-purple-400 flex items-center justify-center font-bold">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <h4 class="font-bold text-white text-base">Assistance WhatsApp</h4>
                    <p class="text-xs text-slate-300">+221 77 000 00 00 / +225 07 00 00 00</p>
                </div>
            </div>

            <div class="lg:col-span-7">
                <div class="glass-panel p-8 sm:p-10 rounded-3xl border border-slate-700/80 shadow-2xl space-y-6">
                    <h3 class="text-xl font-bold font-display text-white">Envoyez-nous un message</h3>

                    <form method="POST" action="{{ route('contact.submit') }}" class="space-y-4">
                        @csrf

                        <div>
                            <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-2">Votre Nom *</label>
                            <input type="text" name="name" required class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 text-white focus:border-cyan-500 focus:outline-none text-sm" placeholder="Amina Diallo">
                        </div>

                        <div>
                            <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-2">Votre Email *</label>
                            <input type="email" name="email" required class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 text-white focus:border-cyan-500 focus:outline-none text-sm" placeholder="amina@example.com">
                        </div>

                        <div>
                            <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-2">Sujet *</label>
                            <input type="text" name="subject" required class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 text-white focus:border-cyan-500 focus:outline-none text-sm" placeholder="Renseignements sur la formation Cybersécurité">
                        </div>

                        <div>
                            <label class="block text-xs font-code uppercase font-bold text-slate-300 mb-2">Message *</label>
                            <textarea name="message" rows="4" required class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 text-white focus:border-cyan-500 focus:outline-none text-sm" placeholder="Posez-nous vos questions..."></textarea>
                        </div>

                        <button type="submit" class="w-full py-3.5 rounded-xl bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-bold text-sm transition-all shadow-neon">
                            Envoyer le message
                        </button>
                    </form>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
