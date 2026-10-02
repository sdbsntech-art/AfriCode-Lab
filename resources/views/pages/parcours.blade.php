@extends('layouts.app')

@section('title', 'Parcours de Formation — AfriCode Lab')

@section('content')
<div class="py-16 bg-grid-pattern">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-3xl mx-auto mb-16 space-y-4">
            <span class="px-3 py-1 rounded-full text-xs font-code font-bold uppercase bg-purple-500/10 text-purple-400 border border-purple-500/30">
                Feuille de Route Pédagogique
            </span>
            <h1 class="text-4xl sm:text-5xl font-extrabold font-display text-white">
                Le Parcours de l'Apprenant AfriCode
            </h1>
            <p class="text-slate-300 text-base">
                De vos premiers pas en informatique jusqu'à votre premier poste en entreprise ou le lancement de votre projet tech.
            </p>
        </div>

        <!-- Interactive Vertical Timeline -->
        <div class="max-w-4xl mx-auto space-y-8 relative before:absolute before:inset-0 before:left-8 sm:before:left-1/2 before:w-0.5 before:bg-gradient-to-b before:from-cyan-500 before:via-emerald-400 before:to-purple-600">
            
            <!-- Step 1 -->
            <div class="relative flex flex-col sm:flex-row items-center justify-between group">
                <div class="sm:w-1/2 sm:pr-8 text-left sm:text-right mb-4 sm:mb-0">
                    <span class="text-xs font-code text-cyan-400 font-bold">Niveau 1 — 1er Mois</span>
                    <h3 class="text-xl font-bold text-white">Initiation & Découverte</h3>
                    <p class="text-xs text-slate-300 mt-1">Prise en main de l'environnement, algorithmique fondamentale, logique de programmation et culture numérique.</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-cyan-500 border-4 border-slate-950 text-slate-950 font-extrabold flex items-center justify-center font-code text-sm z-10 shadow-neon">
                    1
                </div>
                <div class="sm:w-1/2 sm:pl-8"></div>
            </div>

            <!-- Step 2 -->
            <div class="relative flex flex-col sm:flex-row items-center justify-between group">
                <div class="sm:w-1/2 sm:pr-8 hidden sm:block"></div>
                <div class="w-10 h-10 rounded-full bg-emerald-500 border-4 border-slate-950 text-slate-950 font-extrabold flex items-center justify-center font-code text-sm z-10 shadow-neonGreen">
                    2
                </div>
                <div class="sm:w-1/2 sm:pl-8 text-left">
                    <span class="text-xs font-code text-emerald-400 font-bold">Niveau 2 — Mois 2 & 3</span>
                    <h3 class="text-xl font-bold text-white">Fondamentaux Techniques</h3>
                    <p class="text-xs text-slate-300 mt-1">Bases de données SQL, langages du web (HTML, CSS, JS, PHP), systèmes Linux et bases de réseaux TCP/IP.</p>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="relative flex flex-col sm:flex-row items-center justify-between group">
                <div class="sm:w-1/2 sm:pr-8 text-left sm:text-right mb-4 sm:mb-0">
                    <span class="text-xs font-code text-purple-400 font-bold">Niveau 3 — Mois 4 & 5</span>
                    <h3 class="text-xl font-bold text-white">Spécialisation Approfondie</h3>
                    <p class="text-xs text-slate-300 mt-1">Choisissez votre voie : Développement Full-Stack (Laravel/Python), Cybersécurité (Pentest/SOC), Data Science ou Cloud DevOps.</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-purple-500 border-4 border-slate-950 text-white font-extrabold flex items-center justify-center font-code text-sm z-10">
                    3
                </div>
                <div class="sm:w-1/2 sm:pl-8"></div>
            </div>

            <!-- Step 4 -->
            <div class="relative flex flex-col sm:flex-row items-center justify-between group">
                <div class="sm:w-1/2 sm:pr-8 hidden sm:block"></div>
                <div class="w-10 h-10 rounded-full bg-amber-500 border-4 border-slate-950 text-slate-950 font-extrabold flex items-center justify-center font-code text-sm z-10">
                    4
                </div>
                <div class="sm:w-1/2 sm:pl-8 text-left">
                    <span class="text-xs font-code text-amber-400 font-bold">Niveau 4 — Mois 6</span>
                    <h3 class="text-xl font-bold text-white">Projets Réels & Hackathons</h3>
                    <p class="text-xs text-slate-300 mt-1">Conception et livraison de vraies applications informatiques en équipe avec revue de code par des mentors seniors.</p>
                </div>
            </div>

            <!-- Step 5 -->
            <div class="relative flex flex-col sm:flex-row items-center justify-between group">
                <div class="sm:w-1/2 sm:pr-8 text-left sm:text-right mb-4 sm:mb-0">
                    <span class="text-xs font-code text-teal-400 font-bold">Niveau 5 — Carrière</span>
                    <h3 class="text-xl font-bold text-white">Professionnalisation & CV</h3>
                    <p class="text-xs text-slate-300 mt-1">Optimisation du profil GitHub/LinkedIn, préparation aux tests techniques et mise en relation avec le réseau de recrues.</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-teal-400 border-4 border-slate-950 text-slate-950 font-extrabold flex items-center justify-center font-code text-sm z-10">
                    5
                </div>
                <div class="sm:w-1/2 sm:pl-8"></div>
            </div>

        </div>

    </div>
</div>
@endsection
