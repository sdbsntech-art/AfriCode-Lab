@extends('layouts.dashboard')

@section('title', 'Apprendre : ' . $formation->title . ' — AfriCode Lab')
@section('header_title', $formation->title)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    
    <!-- Sidebar: Module & Course List -->
    <div class="lg:col-span-4 xl:col-span-3 space-y-4">
        <div class="glass-panel rounded-2xl border border-slate-800 overflow-hidden">
            <div class="p-4 border-b border-slate-800 bg-slate-950/60">
                <h3 class="text-sm font-bold text-white font-display">Programme de la Formation</h3>
                <div class="mt-2 w-full bg-slate-900 rounded-full h-1.5">
                    <div class="bg-gradient-to-r from-cyan-400 to-emerald-400 h-1.5 rounded-full" style="width: {{ $enrollment->progress_percent }}%"></div>
                </div>
                <p class="text-[10px] font-code text-emerald-400 mt-1">{{ $enrollment->progress_percent }}% complété</p>
            </div>

            <div class="max-h-[60vh] overflow-y-auto">
                @foreach($formation->modules as $module)
                    <div class="border-b border-slate-800/60 last:border-0">
                        <div class="px-4 py-3 bg-slate-950/40">
                            <h4 class="text-xs font-bold text-slate-300 uppercase font-code tracking-wider">{{ $module->title }}</h4>
                        </div>

                        @foreach($module->courses as $course)
                            <a href="{{ route('dashboard.learn', ['formationId' => $formation->id, 'courseId' => $course->id]) }}"
                               class="flex items-center gap-3 px-4 py-3 text-xs transition-all hover:bg-slate-800/50 {{ $activeCourse && $activeCourse->id === $course->id ? 'bg-cyan-500/10 border-l-2 border-cyan-400 text-cyan-300 font-bold' : 'text-slate-400' }}">
                                
                                @if(in_array($course->id, $completedCourseIds))
                                    <i class="fa-solid fa-circle-check text-emerald-400 text-sm flex-shrink-0"></i>
                                @elseif($activeCourse && $activeCourse->id === $course->id)
                                    <i class="fa-solid fa-circle-play text-cyan-400 text-sm flex-shrink-0"></i>
                                @else
                                    <i class="fa-regular fa-circle text-slate-600 text-sm flex-shrink-0"></i>
                                @endif

                                <span class="truncate">{{ $course->title }}</span>
                            </a>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Main Content: Active Lesson -->
    <div class="lg:col-span-8 xl:col-span-9 space-y-6">
        
        @if($activeCourse)
            <!-- Lesson Header -->
            <div class="glass-panel p-6 rounded-2xl border border-slate-800 space-y-4">
                <div class="flex items-center justify-between flex-wrap gap-3">
                    <div class="space-y-1">
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-code uppercase font-bold bg-cyan-500/20 text-cyan-300 border border-cyan-500/30">
                            {{ $activeCourse->module->title }}
                        </span>
                        <h2 class="text-xl sm:text-2xl font-bold font-display text-white">
                            {{ $activeCourse->title }}
                        </h2>
                    </div>

                    <span class="text-xs font-code text-slate-400">
                        <i class="fa-regular fa-clock mr-1"></i> {{ $activeCourse->duration }}
                    </span>
                </div>
            </div>

            <!-- Video Embed Placeholder -->
            @if($activeCourse->video_url)
                <div class="rounded-2xl overflow-hidden border border-slate-800 aspect-video bg-slate-950/50">
                    <iframe src="{{ $activeCourse->video_url }}" class="w-full h-full" frameborder="0" allowfullscreen allow="autoplay; encrypted-media"></iframe>
                </div>
            @endif

            <!-- Lesson Content -->
            <div class="glass-panel p-6 sm:p-8 rounded-2xl border border-slate-800 prose prose-invert prose-sm max-w-none">
                <div class="text-slate-300 leading-relaxed text-sm whitespace-pre-line">
                    {!! nl2br(e($activeCourse->content)) !!}
                </div>
            </div>

            <!-- Action: Mark as Complete -->
            <div class="flex items-center justify-between gap-4 glass-panel p-5 rounded-2xl border border-slate-800">
                @if(in_array($activeCourse->id, $completedCourseIds))
                    <div class="flex items-center gap-2 text-emerald-400 font-bold text-sm">
                        <i class="fa-solid fa-circle-check text-lg"></i> Leçon complétée !
                    </div>
                @else
                    <p class="text-xs text-slate-400">Vous avez terminé cette leçon ?</p>
                    <form method="POST" action="{{ route('dashboard.complete-lesson', $activeCourse->id) }}">
                        @csrf
                        <button type="submit" class="px-6 py-3 rounded-xl bg-gradient-to-r from-emerald-400 to-teal-400 text-slate-950 font-extrabold text-sm shadow-neonGreen hover:scale-[1.02] transition-all">
                            <i class="fa-solid fa-check mr-2"></i> Marquer comme terminée
                        </button>
                    </form>
                @endif
            </div>
        @else
            <div class="glass-panel p-12 rounded-2xl border border-slate-800 text-center space-y-4">
                <i class="fa-solid fa-book-open text-4xl text-slate-600"></i>
                <p class="text-slate-300">Sélectionnez une leçon dans le menu à gauche pour commencer.</p>
            </div>
        @endif

    </div>
</div>
@endsection
