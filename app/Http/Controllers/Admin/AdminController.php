<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Course;
use App\Models\Event;
use App\Models\Formation;
use App\Models\Membership;
use App\Models\Module;
use App\Models\Project;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Dashboard Overview
     */
    public function index(): View
    {
        $upcomingEvents = Event::query()
            ->where(function (Builder $query): void {
                $query->whereNull('event_date')
                    ->orWhereDate('event_date', '>=', today());
            })
            ->orderByRaw('event_date IS NULL')
            ->orderBy('event_date')
            ->take(6)
            ->get();

        $stats = [
            'memberships_total' => Membership::count(),
            'memberships_approved' => Membership::where('status', 'approved')->count(),
            'memberships_pending' => Membership::where('status', 'pending')->count(),
            'applications_pending' => Application::where('status', 'pending')->count(),
        ];

        $recentMemberships = Membership::latest()->take(5)->get();
        $recentApplications = Application::latest()->take(5)->get();

        return view('admin.index', compact('stats', 'recentMemberships', 'recentApplications', 'upcomingEvents'));
    }

    public function memberships(Request $request): View
    {
        $filters = $request->validate([
            'status' => ['nullable', Rule::in(['pending', 'approved', 'rejected'])],
            'search' => ['nullable', 'string', 'max:100'],
        ]);

        $membershipsQuery = Membership::query();

        if (! empty($filters['status'])) {
            $membershipsQuery->where('status', $filters['status']);
        }

        if (! empty($filters['search'])) {
            $search = $filters['search'];

            $membershipsQuery->where(function (Builder $query) use ($search): void {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $memberships = $membershipsQuery->latest()->paginate(12)->withQueryString();
        $membershipStats = [
            'total' => Membership::count(),
            'pending' => Membership::where('status', 'pending')->count(),
            'approved' => Membership::where('status', 'approved')->count(),
            'rejected' => Membership::where('status', 'rejected')->count(),
        ];

        return view('admin.memberships', compact('memberships', 'membershipStats', 'filters'));
    }

    public function updateMembershipStatus(Request $request, Membership $membership): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['pending', 'approved', 'rejected'])],
            'admin_notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $membership->status = $validated['status'];
        $membership->admin_notes = $validated['admin_notes'] ?? null;
        $membership->reviewed_at = $validated['status'] === 'pending' ? null : now();
        $membership->save();

        return redirect()
            ->route('admin.memberships')
            ->with('success', 'La demande d’adhésion a été mise à jour.');
    }

    /**
     * Gestion des Utilisateurs
     */
    public function users(Request $request)
    {
        $query = User::query();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(15);

        return view('admin.users', compact('users'));
    }

    public function updateUserRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:admin,student,trainer',
        ]);

        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();

        return redirect()->back()->with('success', "Le rôle de {$user->name} a été mis à jour en '{$user->role}'.");
    }

    public function toggleUserStatus($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = ! $user->is_active;

        if (! $user->is_active) {
            $user->remember_token = Str::random(60);
        }

        $user->save();

        if (! $user->is_active && config('session.driver') === 'database') {
            DB::connection(config('session.connection'))
                ->table(config('session.table', 'sessions'))
                ->where('user_id', $user->id)
                ->delete();
        }

        $statusStr = $user->is_active ? 'activé' : 'désactivé';

        return redirect()->back()->with('success', "Le compte de {$user->name} a été {$statusStr}.");
    }

    /**
     * Gestion des Formations
     */
    public function formations()
    {
        $formations = Formation::withCount(['modules', 'enrollments'])->latest()->get();

        return view('admin.formations', compact('formations'));
    }

    public function storeFormation(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'domain' => 'required|string',
            'icon' => 'required|string',
            'badge' => 'nullable|string',
            'summary' => 'required|string|max:500',
            'description' => 'required|string',
            'level' => 'required|string',
            'duration' => 'required|string',
        ]);

        $validated['slug'] = Str::slug($validated['title']).'-'.rand(100, 999);
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_published'] = true;

        $formation = Formation::create($validated);

        // Auto-create initial Module 1
        $module = Module::create([
            'formation_id' => $formation->id,
            'title' => 'Module 1 : Introduction & Fondamentaux',
            'description' => 'Découverte des principes de base de la formation.',
            'order' => 1,
        ]);

        Course::create([
            'module_id' => $module->id,
            'title' => 'Leçon 1.1 : Vue d\'ensemble et objectifs',
            'content' => 'Bienvenue dans cette nouvelle formation d\'AfriCode Lab.',
            'duration' => '30 min',
            'is_free_preview' => true,
            'order' => 1,
        ]);

        return redirect()->back()->with('success', "La formation '{$formation->title}' a été créée avec succès !");
    }

    public function deleteFormation($id)
    {
        $formation = Formation::findOrFail($id);
        $formation->delete();

        return redirect()->back()->with('success', 'La formation a été supprimée avec succès.');
    }

    /**
     * Gestion des Projets Apprenants
     */
    public function projects()
    {
        $projects = Project::latest()->get();

        return view('admin.projects', compact('projects'));
    }

    public function storeProject(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:20', 'max:5000'],
            'domain' => ['required', 'string', 'max:100'],
            'technologies' => ['required', 'string', 'max:255'],
            'author_name' => ['required', 'string', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:2048', 'regex:/^https?:\\/\\//i'],
            'demo_url' => ['nullable', 'url', 'max:2048', 'regex:/^https?:\\/\\//i'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120', 'dimensions:max_width=2400,max_height=1800'],
            'is_featured' => ['sometimes', 'boolean'],
        ]);

        $imagePath = $request->file('image')->store('projects', 'public');

        Project::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'domain' => $validated['domain'],
            'technologies' => $validated['technologies'],
            'author_name' => $validated['author_name'],
            'github_url' => $validated['github_url'] ?? null,
            'demo_url' => $validated['demo_url'] ?? null,
            'image_path' => $imagePath,
            'is_featured' => $request->boolean('is_featured'),
            'is_approved' => false,
        ]);

        return redirect()->route('admin.projects')
            ->with('success', 'Le projet a été ajouté et attend votre approbation avant sa publication.');
    }

    public function toggleProjectStatus($id)
    {
        $project = Project::findOrFail($id);
        $project->is_approved = ! $project->is_approved;
        $project->save();

        return redirect()->back()->with('success', 'Statut d\'approbation du projet mis à jour.');
    }

    public function toggleProjectFeatured($id)
    {
        $project = Project::findOrFail($id);
        $project->is_featured = ! $project->is_featured;
        $project->save();

        return redirect()->back()->with('success', 'Statut "Mise en avant" du projet mis à jour.');
    }

    public function deleteProject($id)
    {
        $project = Project::findOrFail($id);
        $imagePath = $project->image_path;

        $project->delete();

        if ($imagePath && str_starts_with($imagePath, 'projects/')) {
            Storage::disk('public')->delete($imagePath);
        }

        return redirect()->back()->with('success', 'Le projet a été supprimé.');
    }

    /**
     * Gestion des Candidatures (Formateurs / Contributeurs)
     */
    public function applications()
    {
        $applications = Application::latest()->get();

        return view('admin.applications', compact('applications'));
    }

    public function updateApplicationStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'admin_notes' => 'nullable|string',
        ]);

        $application = Application::findOrFail($id);
        $application->status = $request->status;
        $application->admin_notes = $request->admin_notes;
        $application->save();

        // If approved, upgrade applicant user or send notification if registered
        if ($application->status === 'approved') {
            $user = User::where('email', $application->email)->first();
            if ($user && $user->role === 'student') {
                $user->role = 'trainer';
                $user->save();
            }
        }

        return redirect()->back()->with('success', "Candidature de {$application->name} mise à jour : {$application->status}.");
    }

    /**
     * Gestion des Événements
     */
    public function events()
    {
        $events = Event::latest()->get();

        return view('admin.events', compact('events'));
    }

    public function storeEvent(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', Rule::in(['Webinaire', 'Atelier', 'Hackathon', 'Conférence'])],
            'event_date' => ['nullable', 'date', 'after_or_equal:today'],
            'event_time' => ['nullable', 'string', 'max:50'],
            'location' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'registration_url' => ['nullable', 'url', 'max:255'],
        ]);

        $validated['is_featured'] = true;
        Event::create($validated);

        return back()->with('success', 'L\'événement a été planifié avec succès.');
    }

    public function updateEventDate(Request $request, Event $event): RedirectResponse
    {
        $validated = $request->validate([
            'event_date' => ['nullable', 'date', 'after_or_equal:today'],
            'event_time' => ['nullable', 'string', 'max:50'],
        ]);

        $event->event_date = $validated['event_date'] ?? null;
        if (array_key_exists('event_time', $validated)) {
            $event->event_time = $validated['event_time'];
        }
        $event->save();

        return back()->with('success', "La date de l'événement '{$event->title}' a été mise à jour !");
    }

    public function deleteEvent($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->back()->with('success', 'Événement supprimé.');
    }

    /**
     * Témoignages
     */
    public function testimonials()
    {
        $testimonials = Testimonial::latest()->get();

        return view('admin.testimonials', compact('testimonials'));
    }

    public function storeTestimonial(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role_title' => 'required|string|max:255',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $validated['is_featured'] = true;
        Testimonial::create($validated);

        return redirect()->back()->with('success', 'Témoignage ajouté avec succès.');
    }

    public function deleteTestimonial($id)
    {
        $t = Testimonial::findOrFail($id);
        $t->delete();

        return redirect()->back()->with('success', 'Témoignage supprimé.');
    }
}
