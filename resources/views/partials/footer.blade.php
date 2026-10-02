<footer class="bg-[#18382b] text-white">
    <div class="mx-auto max-w-7xl px-5 py-14 sm:px-8 lg:px-12 lg:py-16">
        <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-12">
            <div class="lg:col-span-5">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="" class="h-12 w-12 rounded-xl object-cover">
                    <span class="font-display text-xl font-bold tracking-wide">AFRICODE <span class="text-[#e9a15b]">LAB</span></span>
                </a>
                <p class="mt-5 max-w-md text-sm leading-7 text-white/70">
                    Une initiative panafricaine pour fédérer les talents et contribuer à un numérique africain imaginé, conçu et construit sur le continent.
                </p>
                <a href="{{ route('membership.create') }}" class="mt-6 inline-flex items-center gap-2 rounded-full bg-[#e9a15b] px-5 py-3 text-sm font-bold text-[#18382b] transition hover:bg-[#f0b776]">
                    Adhérer à AfriCode Lab <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
                </a>
            </div>

            <div class="lg:col-span-2 lg:col-start-7">
                <h2 class="text-xs font-bold uppercase tracking-[0.18em] text-[#e9a15b]">Découvrir</h2>
                <ul class="mt-5 space-y-3 text-sm text-white/75">
                    <li><a href="{{ route('about') }}" class="transition hover:text-white">Notre vision</a></li>
                    <li><a href="{{ route('home') }}#programme" class="transition hover:text-white">Notre programme</a></li>
                    <li><a href="{{ route('projects') }}" class="transition hover:text-white">Projets</a></li>
                    <li><a href="{{ route('community') }}" class="transition hover:text-white">Communauté</a></li>
                </ul>
            </div>

            <div class="lg:col-span-3">
                <h2 class="text-xs font-bold uppercase tracking-[0.18em] text-[#e9a15b]">Participer</h2>
                <ul class="mt-5 space-y-3 text-sm text-white/75">
                    <li><a href="{{ route('contribute') }}" class="transition hover:text-white">Candidater / contribuer</a></li>
                    <li><a href="{{ route('membership.create') }}" class="transition hover:text-white">Demande d’adhésion</a></li>
                    <li><a href="{{ route('contact') }}" class="transition hover:text-white">Devenir partenaire</a></li>
                    <li><a href="{{ route('contact') }}" class="transition hover:text-white">Nous contacter</a></li>
                    <li><a href="{{ route('login') }}" class="transition hover:text-white">Connexion</a></li>
                </ul>
            </div>
        </div>

        <div class="mt-12 flex flex-col gap-4 border-t border-white/15 pt-6 text-xs text-white/55 sm:flex-row sm:items-center sm:justify-between">
            <p>© {{ date('Y') }} AfriCode Lab. Tous droits réservés.</p>
            <p class="max-w-xl leading-5 sm:text-right">Le talent africain existe. Ensemble, donnons-lui l’espace pour construire l’avenir.</p>
        </div>
    </div>
</footer>
