@extends('layouts.app')

@section('title', 'Candidater ou contribuer — AfriCode Lab')
@section('meta_description', 'Professionnels, experts, mentors, partenaires : proposez votre contribution au développement du numérique africain avec AfriCode Lab.')

@section('content')
<section class="bg-[#f6f3eb] py-16 sm:py-20">
    <div class="mx-auto max-w-6xl px-5 sm:px-8 lg:px-12">
        <div class="mx-auto max-w-3xl text-center">
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#b85e32]">Appel à contribution</p>
            <h1 class="mt-5 font-display text-4xl font-bold leading-tight text-[#18382b] sm:text-5xl">
                Votre expertise peut faire avancer une vision.
            </h1>
            <p class="mt-5 text-base leading-7 text-[#647167] sm:text-lg">
                AfriCode Lab invite les professionnels et les organisations qui souhaitent contribuer au développement du numérique en Afrique. Partagez votre parcours : nous prendrons contact pour imaginer la suite ensemble.
            </p>
        </div>

        <div class="mx-auto mt-10 grid max-w-4xl grid-cols-2 gap-3 sm:grid-cols-4">
            <div class="rounded-2xl border border-[#e5e4dc] bg-white p-4 text-center">
                <i class="fa-solid fa-code text-xl text-[#1d4935]" aria-hidden="true"></i>
                <p class="mt-2 text-xs font-bold text-[#304b3a]">Professionnels</p>
            </div>
            <div class="rounded-2xl border border-[#e5e4dc] bg-white p-4 text-center">
                <i class="fa-solid fa-compass-drafting text-xl text-[#b85e32]" aria-hidden="true"></i>
                <p class="mt-2 text-xs font-bold text-[#304b3a]">Experts & mentors</p>
            </div>
            <div class="rounded-2xl border border-[#e5e4dc] bg-white p-4 text-center">
                <i class="fa-solid fa-handshake text-xl text-[#1d4935]" aria-hidden="true"></i>
                <p class="mt-2 text-xs font-bold text-[#304b3a]">Partenaires</p>
            </div>
            <div class="rounded-2xl border border-[#e5e4dc] bg-white p-4 text-center">
                <i class="fa-solid fa-people-group text-xl text-[#b85e32]" aria-hidden="true"></i>
                <p class="mt-2 text-xs font-bold text-[#304b3a]">Contributeurs</p>
            </div>
        </div>

        <div class="mx-auto mt-10 max-w-4xl rounded-[2rem] border border-[#e5e4dc] bg-white p-6 shadow-sm sm:p-10">
            <div class="border-b border-[#e9e7df] pb-6">
                <h2 class="font-display text-2xl font-bold text-[#18382b]">Parlons de votre contribution</h2>
                <p class="mt-2 text-sm leading-6 text-[#647167]">Les champs marqués d’un astérisque sont obligatoires.</p>
            </div>

            <form method="POST" action="{{ route('contribute.submit') }}" class="mt-7 space-y-6">
                @csrf

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="name" class="mb-2 block text-sm font-semibold text-[#304b3a]">Nom complet *</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" class="w-full rounded-xl border border-[#d9ded5] bg-[#fcfbf8] px-4 py-3 text-sm text-[#18382b] outline-none transition placeholder:text-[#96a096] focus:border-[#1d4935] focus:ring-2 focus:ring-[#1d4935]/10" placeholder="Votre nom">
                        @error('name')<p class="mt-1 text-sm text-red-700">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="email" class="mb-2 block text-sm font-semibold text-[#304b3a]">Adresse e-mail *</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" class="w-full rounded-xl border border-[#d9ded5] bg-[#fcfbf8] px-4 py-3 text-sm text-[#18382b] outline-none transition placeholder:text-[#96a096] focus:border-[#1d4935] focus:ring-2 focus:ring-[#1d4935]/10" placeholder="vous@exemple.com">
                        @error('email')<p class="mt-1 text-sm text-red-700">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="phone" class="mb-2 block text-sm font-semibold text-[#304b3a]">Téléphone / WhatsApp</label>
                        <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel" class="w-full rounded-xl border border-[#d9ded5] bg-[#fcfbf8] px-4 py-3 text-sm text-[#18382b] outline-none transition placeholder:text-[#96a096] focus:border-[#1d4935] focus:ring-2 focus:ring-[#1d4935]/10" placeholder="+221 77 000 00 00">
                        @error('phone')<p class="mt-1 text-sm text-red-700">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="role_applied" class="mb-2 block text-sm font-semibold text-[#304b3a]">Comment souhaitez-vous contribuer ? *</label>
                        <select id="role_applied" name="role_applied" required class="w-full rounded-xl border border-[#d9ded5] bg-[#fcfbf8] px-4 py-3 text-sm text-[#18382b] outline-none transition focus:border-[#1d4935] focus:ring-2 focus:ring-[#1d4935]/10">
                            <option value="">Choisir une contribution</option>
                            @foreach(['Professionnel / bénévole', 'Expert / intervenant', 'Mentor', 'Contributeur technique', 'Partenaire / organisation', 'Conférencier'] as $role)
                                <option value="{{ $role }}" @selected(old('role_applied') === $role)>{{ $role }}</option>
                            @endforeach
                        </select>
                        @error('role_applied')<p class="mt-1 text-sm text-red-700">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="domain_expertise" class="mb-2 block text-sm font-semibold text-[#304b3a]">Votre domaine principal *</label>
                        <select id="domain_expertise" name="domain_expertise" required class="w-full rounded-xl border border-[#d9ded5] bg-[#fcfbf8] px-4 py-3 text-sm text-[#18382b] outline-none transition focus:border-[#1d4935] focus:ring-2 focus:ring-[#1d4935]/10">
                            <option value="">Choisir un domaine</option>
                            @foreach(['Développement & Web', 'Cybersécurité', 'Data & Intelligence Artificielle', 'Réseaux & Infrastructures', 'DevOps & Cloud', 'Gestion de projets numériques', 'Partenariat & stratégie', 'Communication & mobilisation', 'Autre expertise'] as $domain)
                                <option value="{{ $domain }}" @selected(old('domain_expertise') === $domain)>{{ $domain }}</option>
                            @endforeach
                        </select>
                        @error('domain_expertise')<p class="mt-1 text-sm text-red-700">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="experience_years" class="mb-2 block text-sm font-semibold text-[#304b3a]">Expérience dans ce domaine *</label>
                        <select id="experience_years" name="experience_years" required class="w-full rounded-xl border border-[#d9ded5] bg-[#fcfbf8] px-4 py-3 text-sm text-[#18382b] outline-none transition focus:border-[#1d4935] focus:ring-2 focus:ring-[#1d4935]/10">
                            <option value="">Choisir une expérience</option>
                            @foreach(['Moins d’un an', '1-3 ans', '3-5 ans', '5-10 ans', '10+ ans'] as $experience)
                                <option value="{{ $experience }}" @selected(old('experience_years') === $experience)>{{ $experience }}</option>
                            @endforeach
                        </select>
                        @error('experience_years')<p class="mt-1 text-sm text-red-700">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="github_url" class="mb-2 block text-sm font-semibold text-[#304b3a]">Profil GitHub</label>
                        <input id="github_url" type="url" name="github_url" value="{{ old('github_url') }}" class="w-full rounded-xl border border-[#d9ded5] bg-[#fcfbf8] px-4 py-3 text-sm text-[#18382b] outline-none transition placeholder:text-[#96a096] focus:border-[#1d4935] focus:ring-2 focus:ring-[#1d4935]/10" placeholder="https://github.com/votreprofil">
                        @error('github_url')<p class="mt-1 text-sm text-red-700">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="linkedin_url" class="mb-2 block text-sm font-semibold text-[#304b3a]">Profil LinkedIn</label>
                        <input id="linkedin_url" type="url" name="linkedin_url" value="{{ old('linkedin_url') }}" class="w-full rounded-xl border border-[#d9ded5] bg-[#fcfbf8] px-4 py-3 text-sm text-[#18382b] outline-none transition placeholder:text-[#96a096] focus:border-[#1d4935] focus:ring-2 focus:ring-[#1d4935]/10" placeholder="https://linkedin.com/in/votreprofil">
                        @error('linkedin_url')<p class="mt-1 text-sm text-red-700">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label for="bio" class="mb-2 block text-sm font-semibold text-[#304b3a]">Parlez-nous de vous et de votre motivation *</label>
                    <textarea id="bio" name="bio" rows="5" required minlength="20" class="w-full rounded-xl border border-[#d9ded5] bg-[#fcfbf8] px-4 py-3 text-sm leading-6 text-[#18382b] outline-none transition placeholder:text-[#96a096] focus:border-[#1d4935] focus:ring-2 focus:ring-[#1d4935]/10" placeholder="Votre parcours, vos compétences et la manière dont vous aimeriez contribuer…">{{ old('bio') }}</textarea>
                    @error('bio')<p class="mt-1 text-sm text-red-700">{{ $message }}</p>@enderror
                </div>

                <div class="flex flex-col gap-4 border-t border-[#e9e7df] pt-6 sm:flex-row sm:items-center sm:justify-between">
                    <p class="max-w-md text-xs leading-5 text-[#718075]">Les informations partagées serviront à étudier votre proposition et à vous recontacter au sujet de votre contribution.</p>
                    <button type="submit" class="inline-flex shrink-0 items-center justify-center gap-3 rounded-full bg-[#1d4935] px-7 py-4 text-sm font-bold text-white transition hover:bg-[#143a29]">
                        Envoyer ma candidature <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
