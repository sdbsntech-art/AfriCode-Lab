@extends('layouts.app')

@section('title', 'Adhérer à AfriCode Lab')
@section('meta_description', 'Déposez votre demande d’adhésion à AfriCode Lab et participez à une initiative collective pour le développement du numérique africain.')

@section('content')
<section class="bg-[#f6f3eb] py-16 sm:py-20">
    <div class="mx-auto max-w-5xl px-5 sm:px-8 lg:px-12">
        <header class="mx-auto max-w-3xl text-center">
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#b85e32]">Rejoindre le mouvement</p>
            <h1 class="mt-5 font-display text-4xl font-bold leading-tight text-[#18382b] sm:text-5xl">Adhérer à AfriCode Lab</h1>
            <p class="mt-5 text-base leading-7 text-[#647167] sm:text-lg">
                Rejoignez une initiative panafricaine qui rassemble les talents et les professionnels engagés dans le développement du numérique en Afrique.
            </p>
        </header>

        <div class="mx-auto mt-10 max-w-3xl rounded-[2rem] border border-[#e5e4dc] bg-white p-6 shadow-sm sm:p-10">
            <div class="border-b border-[#e9e7df] pb-6">
                <h2 class="font-display text-2xl font-bold text-[#18382b]">Votre demande d’adhésion</h2>
                <p class="mt-2 text-sm leading-6 text-[#647167]">Après réception, notre équipe étudiera votre demande et vous recontactera.</p>
            </div>

            <form method="POST" action="{{ route('membership.store') }}" class="mt-7 space-y-6">
                @csrf

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="name" class="mb-2 block text-sm font-semibold text-[#304b3a]">Nom complet *</label>
                        <input id="name" type="text" name="name" value="{{ old('name', auth()->user()?->name) }}" required autocomplete="name" class="w-full rounded-xl border border-[#d9ded5] bg-[#fcfbf8] px-4 py-3 text-sm text-[#18382b] outline-none transition placeholder:text-[#96a096] focus:border-[#1d4935] focus:ring-2 focus:ring-[#1d4935]/10" placeholder="Votre nom">
                        @error('name')<p class="mt-1 text-sm text-red-700">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="email" class="mb-2 block text-sm font-semibold text-[#304b3a]">Adresse e-mail *</label>
                        <input id="email" type="email" name="email" value="{{ old('email', auth()->user()?->email) }}" required autocomplete="email" class="w-full rounded-xl border border-[#d9ded5] bg-[#fcfbf8] px-4 py-3 text-sm text-[#18382b] outline-none transition placeholder:text-[#96a096] focus:border-[#1d4935] focus:ring-2 focus:ring-[#1d4935]/10" placeholder="vous@exemple.com">
                        @error('email')<p class="mt-1 text-sm text-red-700">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="phone" class="mb-2 block text-sm font-semibold text-[#304b3a]">Téléphone / WhatsApp</label>
                        <input id="phone" type="tel" name="phone" value="{{ old('phone', auth()->user()?->phone) }}" autocomplete="tel" class="w-full rounded-xl border border-[#d9ded5] bg-[#fcfbf8] px-4 py-3 text-sm text-[#18382b] outline-none transition placeholder:text-[#96a096] focus:border-[#1d4935] focus:ring-2 focus:ring-[#1d4935]/10" placeholder="+221 77 000 00 00">
                        @error('phone')<p class="mt-1 text-sm text-red-700">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="membership_type" class="mb-2 block text-sm font-semibold text-[#304b3a]">Type d’adhésion *</label>
                        <select id="membership_type" name="membership_type" required class="w-full rounded-xl border border-[#d9ded5] bg-[#fcfbf8] px-4 py-3 text-sm text-[#18382b] outline-none transition focus:border-[#1d4935] focus:ring-2 focus:ring-[#1d4935]/10">
                            <option value="">Choisir un profil</option>
                            @foreach($membershipTypes as $value => $label)
                                <option value="{{ $value }}" @selected(old('membership_type') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('membership_type')<p class="mt-1 text-sm text-red-700">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label for="expertise" class="mb-2 block text-sm font-semibold text-[#304b3a]">Domaine d’expertise ou d’intérêt</label>
                    <input id="expertise" type="text" name="expertise" value="{{ old('expertise') }}" class="w-full rounded-xl border border-[#d9ded5] bg-[#fcfbf8] px-4 py-3 text-sm text-[#18382b] outline-none transition placeholder:text-[#96a096] focus:border-[#1d4935] focus:ring-2 focus:ring-[#1d4935]/10" placeholder="Ex. développement, cybersécurité, entrepreneuriat">
                    @error('expertise')<p class="mt-1 text-sm text-red-700">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="motivation" class="mb-2 block text-sm font-semibold text-[#304b3a]">Pourquoi souhaitez-vous adhérer ? *</label>
                    <textarea id="motivation" name="motivation" rows="5" required minlength="20" maxlength="3000" class="w-full rounded-xl border border-[#d9ded5] bg-[#fcfbf8] px-4 py-3 text-sm leading-6 text-[#18382b] outline-none transition placeholder:text-[#96a096] focus:border-[#1d4935] focus:ring-2 focus:ring-[#1d4935]/10" placeholder="Parlez-nous de votre motivation et de la manière dont vous aimeriez participer…">{{ old('motivation') }}</textarea>
                    @error('motivation')<p class="mt-1 text-sm text-red-700">{{ $message }}</p>@enderror
                </div>

                <div class="flex flex-col gap-4 border-t border-[#e9e7df] pt-6 sm:flex-row sm:items-center sm:justify-between">
                    <p class="max-w-md text-xs leading-5 text-[#718075]">La demande sera enregistrée avec le statut « en attente » jusqu’à son examen par l’équipe.</p>
                    <button type="submit" class="inline-flex shrink-0 items-center justify-center gap-3 rounded-full bg-[#1d4935] px-7 py-4 text-sm font-bold text-white transition hover:bg-[#143a29]">
                        Envoyer ma demande <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
