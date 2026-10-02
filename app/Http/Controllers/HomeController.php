<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Event;
use App\Models\Formation;
use App\Models\Project;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Landing Page
     */
    public function index()
    {
        $featuredFormations = Formation::where('is_featured', true)
            ->where('is_published', true)
            ->withCount('modules')
            ->take(6)
            ->get();

        $featuredProjects = Project::where('is_featured', true)
            ->where('is_approved', true)
            ->take(4)
            ->get();

        $featuredEvents = Event::where('is_featured', true)
            ->orderBy('event_date', 'asc')
            ->take(3)
            ->get();

        $testimonials = Testimonial::where('is_featured', true)
            ->take(4)
            ->get();

        $stats = [
            'students' => 1250,
            'trainers' => 45,
            'formations' => Formation::count(),
            'projects' => Project::count(),
            'countries' => 18,
        ];

        return view('home', compact('featuredFormations', 'featuredProjects', 'featuredEvents', 'testimonials', 'stats'));
    }

    /**
     * Section / Page À Propos
     */
    public function about()
    {
        return view('pages.about');
    }

    /**
     * Catalogue des Formations
     */
    public function formations(Request $request)
    {
        $query = Formation::where('is_published', true);

        if ($request->filled('domain')) {
            $query->where('domain', $request->domain);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('summary', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $formations = $query->withCount('modules')->get();

        return view('pages.formations', compact('formations'));
    }

    /**
     * Détail d'une Formation
     */
    public function showFormation($slug)
    {
        $formation = Formation::where('slug', $slug)
            ->where('is_published', true)
            ->with(['modules.courses'])
            ->firstOrFail();

        $isEnrolled = false;
        if (auth()->check()) {
            $isEnrolled = auth()->user()->enrollments()->where('formation_id', $formation->id)->exists();
        }

        return view('pages.formation-detail', compact('formation', 'isEnrolled'));
    }

    /**
     * Parcours de formation (Timeline interactive)
     */
    public function parcours()
    {
        return view('pages.parcours');
    }

    /**
     * Projets & Réalisations des Apprenants
     */
    public function projects(Request $request)
    {
        $filters = $request->validate([
            'domain' => ['nullable', 'string', 'max:100'],
        ]);

        $projects = Project::query()
            ->where('is_approved', true)
            ->when($filters['domain'] ?? null, fn ($query, $domain) => $query->where('domain', $domain))
            ->orderByDesc('is_featured')
            ->latest()
            ->get();
        $domains = Project::query()
            ->where('is_approved', true)
            ->select('domain')
            ->distinct()
            ->orderBy('domain')
            ->pluck('domain');

        return view('pages.projects', compact('projects', 'domains'));
    }

    /**
     * Espace Communauté Panafricaine
     */
    public function community()
    {
        $events = Event::query()
            ->where(function ($query) {
                $query->whereNull('event_date')
                    ->orWhereDate('event_date', '>=', today());
            })
            ->orderByRaw('event_date IS NULL')
            ->orderBy('event_date')
            ->get();
        $testimonials = Testimonial::where('is_featured', true)
            ->latest()
            ->take(3)
            ->get();

        return view('pages.community', compact('events', 'testimonials'));
    }

    /**
     * Page Appel aux Formateurs et Contributeurs ("Rejoignez notre mission")
     */
    public function contribute()
    {
        return view('pages.contribute');
    }

    /**
     * Soumission du Formulaire de Candidature Formateur / Contributeur
     */
    public function submitApplication(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'role_applied' => 'required|string',
            'domain_expertise' => 'required|string',
            'experience_years' => 'required|string',
            'bio' => 'required|string|min:20',
            'github_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
        ]);

        Application::create($validated);

        return redirect()->back()->with('success', 'Votre candidature a été transmise avec succès ! L\'équipe AfriCode Lab vous recontactera sous 48h.');
    }

    /**
     * Page Contact
     */
    public function contact()
    {
        return view('pages.contact');
    }

    /**
     * Soumission Formulaire Contact
     */
    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        return redirect()->back()->with('success', 'Merci pour votre message ! Notre équipe vous répondra dans les plus brefs délais.');
    }
}
