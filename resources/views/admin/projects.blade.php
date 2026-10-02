@extends('layouts.admin')

@section('title', 'Gestion des projets — Admin AfriCode Lab')
@section('header_title', 'Projets & réalisations')

@section('content')
<div x-data="{ showForm: @js($errors->any()) }" class="space-y-7">
    <section class="flex flex-col gap-5 rounded-3xl border border-[#e3e4dc] bg-white p-6 shadow-sm sm:flex-row sm:items-center sm:justify-between sm:p-8">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#b85e32]">Galerie publique</p>
            <h2 class="mt-2 font-display text-2xl font-bold text-[#18382b]">Publier et gérer les projets</h2>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-[#647167]">Ajoutez une réalisation avec son visuel et ses liens. Les projets créés ici restent en attente jusqu’à votre validation.</p>
        </div>
        <button type="button" @click="showForm = !showForm" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-full bg-[#1d4935] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#18382b]">
            <i class="fa-solid fa-plus" aria-hidden="true"></i>
            <span x-text="showForm ? 'Fermer le formulaire' : 'Ajouter un projet'"></span>
        </button>
    </section>

    <section x-show="showForm" x-cloak class="rounded-3xl border border-[#d9ded5] bg-white p-6 shadow-sm sm:p-8">
        <div class="mb-7 border-b border-[#e9e7df] pb-5">
            <h3 class="font-display text-xl font-bold text-[#18382b]">Nouveau projet à présenter</h3>
            <p class="mt-2 text-sm text-[#647167]">L’image doit être un fichier JPG, PNG ou WebP (5 Mo maximum). Les fichiers SVG ne sont pas acceptés pour les téléversements.</p>
        </div>

        <form method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="title" class="mb-2 block text-sm font-semibold text-[#304b3a]">Nom du projet *</label>
                    <input id="title" name="title" value="{{ old('title') }}" required maxlength="255" class="w-full rounded-xl border border-[#d9ded5] bg-[#fcfbf8] px-4 py-3 text-sm text-[#18382b] outline-none focus:border-[#1d4935] focus:ring-2 focus:ring-[#1d4935]/10">
                    @error('title')<p class="mt-1 text-sm text-red-700">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="author_name" class="mb-2 block text-sm font-semibold text-[#304b3a]">Auteur / équipe *</label>
                    <input id="author_name" name="author_name" value="{{ old('author_name') }}" required maxlength="255" class="w-full rounded-xl border border-[#d9ded5] bg-[#fcfbf8] px-4 py-3 text-sm text-[#18382b] outline-none focus:border-[#1d4935] focus:ring-2 focus:ring-[#1d4935]/10">
                    @error('author_name')<p class="mt-1 text-sm text-red-700">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="domain" class="mb-2 block text-sm font-semibold text-[#304b3a]">Domaine *</label>
                    <input id="domain" name="domain" value="{{ old('domain') }}" required maxlength="100" placeholder="Ex. Agriculture & gestion" class="w-full rounded-xl border border-[#d9ded5] bg-[#fcfbf8] px-4 py-3 text-sm text-[#18382b] outline-none focus:border-[#1d4935] focus:ring-2 focus:ring-[#1d4935]/10">
                    @error('domain')<p class="mt-1 text-sm text-red-700">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="technologies" class="mb-2 block text-sm font-semibold text-[#304b3a]">Technologies / type de projet *</label>
                    <input id="technologies" name="technologies" value="{{ old('technologies') }}" required maxlength="255" placeholder="Ex. Application web" class="w-full rounded-xl border border-[#d9ded5] bg-[#fcfbf8] px-4 py-3 text-sm text-[#18382b] outline-none focus:border-[#1d4935] focus:ring-2 focus:ring-[#1d4935]/10">
                    @error('technologies')<p class="mt-1 text-sm text-red-700">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label for="description" class="mb-2 block text-sm font-semibold text-[#304b3a]">Description *</label>
                <textarea id="description" name="description" rows="4" required minlength="20" maxlength="5000" class="w-full rounded-xl border border-[#d9ded5] bg-[#fcfbf8] px-4 py-3 text-sm leading-6 text-[#18382b] outline-none focus:border-[#1d4935] focus:ring-2 focus:ring-[#1d4935]/10">{{ old('description') }}</textarea>
                @error('description')<p class="mt-1 text-sm text-red-700">{{ $message }}</p>@enderror
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="demo_url" class="mb-2 block text-sm font-semibold text-[#304b3a]">Lien vers le projet (facultatif)</label>
                    <input id="demo_url" type="url" name="demo_url" value="{{ old('demo_url') }}" placeholder="https://exemple.com" class="w-full rounded-xl border border-[#d9ded5] bg-[#fcfbf8] px-4 py-3 text-sm text-[#18382b] outline-none focus:border-[#1d4935] focus:ring-2 focus:ring-[#1d4935]/10">
                    @error('demo_url')<p class="mt-1 text-sm text-red-700">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="github_url" class="mb-2 block text-sm font-semibold text-[#304b3a]">Lien GitHub (facultatif)</label>
                    <input id="github_url" type="url" name="github_url" value="{{ old('github_url') }}" placeholder="https://github.com/..." class="w-full rounded-xl border border-[#d9ded5] bg-[#fcfbf8] px-4 py-3 text-sm text-[#18382b] outline-none focus:border-[#1d4935] focus:ring-2 focus:ring-[#1d4935]/10">
                    @error('github_url')<p class="mt-1 text-sm text-red-700">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label for="image" class="mb-2 block text-sm font-semibold text-[#304b3a]">Visuel du projet *</label>
                <input id="image" type="file" name="image" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" required class="block w-full rounded-xl border border-[#d9ded5] bg-[#fcfbf8] text-sm text-[#526258] file:mr-4 file:border-0 file:bg-[#e8eee5] file:px-4 file:py-3 file:text-sm file:font-bold file:text-[#1d4935]">
                @error('image')<p class="mt-1 text-sm text-red-700">{{ $message }}</p>@enderror
            </div>

            <label class="inline-flex items-center gap-3 text-sm font-medium text-[#526258]">
                <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured')) class="h-4 w-4 rounded border-[#cbd4c9] text-[#1d4935] focus:ring-[#1d4935]">
                Mettre le projet en avant dans la galerie
            </label>

            <div class="border-t border-[#e9e7df] pt-5">
                <button type="submit" class="inline-flex items-center gap-2 rounded-full bg-[#1d4935] px-6 py-3 text-sm font-bold text-white transition hover:bg-[#18382b]">
                    Enregistrer pour validation <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
                </button>
            </div>
        </form>
    </section>

    <section>
        <div class="mb-4 flex items-end justify-between gap-4">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#b85e32]">Bibliothèque</p>
                <h3 class="mt-2 font-display text-xl font-bold text-[#18382b]">{{ $projects->count() }} {{ $projects->count() === 1 ? 'projet' : 'projets' }}</h3>
            </div>
            <p class="text-xs text-[#647167]">Les projets approuvés sont visibles sur le site.</p>
        </div>

        @if($projects->isNotEmpty())
            <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                @foreach($projects as $project)
                    <article class="overflow-hidden rounded-3xl border border-[#e3e4dc] bg-white shadow-sm">
                        <div class="relative aspect-[16/9] bg-[#e8eee5]">
                            @if($project->image_path)
                                <img src="{{ asset(str_starts_with($project->image_path, 'projects/') ? 'storage/'.$project->image_path : $project->image_path) }}" alt="Visuel du projet {{ $project->title }}" class="h-full w-full object-cover">
                            @else
                                <div class="flex h-full items-center justify-center text-4xl text-[#1d4935]"><i class="fa-solid fa-laptop-code" aria-hidden="true"></i></div>
                            @endif
                        </div>
                        <div class="space-y-4 p-5">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <h4 class="font-display text-lg font-bold text-[#18382b]">{{ $project->title }}</h4>
                                    <p class="mt-1 text-xs text-[#647167]">{{ $project->author_name }}</p>
                                </div>
                                <span class="shrink-0 rounded-full px-3 py-1 text-[10px] font-bold {{ $project->is_approved ? 'bg-[#e8eee5] text-[#1d4935]' : 'bg-[#f5e9de] text-[#8a5b2c]' }}">
                                    {{ $project->is_approved ? 'Publié' : 'En attente' }}
                                </span>
                            </div>
                            <p class="line-clamp-3 text-sm leading-6 text-[#647167]">{{ $project->description }}</p>
                            <p class="text-xs font-semibold text-[#526258]">{{ $project->domain }} · {{ $project->technologies }}</p>
                            <div class="flex flex-wrap items-center gap-2 border-t border-[#e9e7df] pt-4">
                                <form method="POST" action="{{ route('admin.projects.approve', $project) }}">
                                    @csrf
                                    <button type="submit" class="rounded-full border border-[#cbd4c9] px-3 py-2 text-xs font-bold text-[#1d4935] transition hover:border-[#1d4935]">
                                        {{ $project->is_approved ? 'Retirer du site' : 'Approuver & publier' }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.projects.featured', $project) }}">
                                    @csrf
                                    <button type="submit" class="rounded-full border border-[#e4d2b7] px-3 py-2 text-xs font-bold text-[#8a5b2c] transition hover:bg-[#fbf5eb]">
                                        {{ $project->is_featured ? '★ À la une' : '☆ Mettre à la une' }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.projects.delete', $project) }}" onsubmit="return confirm('Supprimer ce projet ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-full border border-[#ead2cc] px-3 py-2 text-xs font-bold text-[#a44735] transition hover:bg-[#fcf2f0]">Supprimer</button>
                                </form>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="rounded-3xl border border-dashed border-[#cbd4c9] bg-white px-6 py-12 text-center">
                <i class="fa-solid fa-lightbulb text-2xl text-[#1d4935]" aria-hidden="true"></i>
                <p class="mt-3 text-sm font-semibold text-[#526258]">Aucun projet enregistré pour le moment.</p>
                <button type="button" @click="showForm = true" class="mt-4 rounded-full bg-[#1d4935] px-5 py-2.5 text-sm font-bold text-white">Ajouter le premier projet</button>
            </div>
        @endif
    </section>
</div>
@endsection
