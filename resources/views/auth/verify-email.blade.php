@extends('layouts.app')

@section('title', 'Vérifiez votre adresse e-mail — AfriCode Lab')

@section('content')
<section class="flex min-h-[65vh] items-center justify-center px-5 py-16 sm:px-8">
    <div class="w-full max-w-xl rounded-3xl border border-[#e5e4dc] bg-white p-7 shadow-sm sm:p-10">
        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#e8eee5] text-xl text-[#1d4935]">
            <i class="fa-regular fa-envelope" aria-hidden="true"></i>
        </div>
        <h1 class="mt-6 text-center font-display text-2xl font-bold text-[#18382b]">Vérifiez votre adresse e-mail</h1>
        <p class="mt-3 text-center text-sm leading-6 text-[#647167]">
            Avant de continuer, ouvrez le lien de vérification envoyé à votre adresse e-mail. Si vous ne l’avez pas reçu, vous pouvez en demander un nouveau.
        </p>

        @if (session('status'))
            <p class="mt-5 rounded-xl border border-[#cbd4c9] bg-[#f6f3eb] px-4 py-3 text-sm text-[#1d4935]">{{ session('status') }}</p>
        @endif

        <form method="POST" action="{{ route('verification.send') }}" class="mt-6">
            @csrf
            <button type="submit" class="w-full rounded-full bg-[#1d4935] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#18382b]">
                Renvoyer le lien de vérification
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="mt-3 text-center">
            @csrf
            <button type="submit" class="px-4 py-2 text-sm font-semibold text-[#647167] underline-offset-4 hover:text-[#18382b] hover:underline">
                Se déconnecter
            </button>
        </form>
    </div>
</section>
@endsection
