<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Formation;
use App\Models\Notification;
use App\Models\Progress;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $enrollments = Enrollment::where('user_id', $user->id)
            ->with(['formation.modules.courses'])
            ->get();

        $totalEnrollments = $enrollments->count();
        $completedFormations = $enrollments->where('status', 'completed')->count();
        $avgProgress = $totalEnrollments > 0 ? round($enrollments->avg('progress_percent')) : 0;

        $userProjects = Project::where('user_id', $user->id)->get();
        $notifications = Notification::where('user_id', $user->id)->take(5)->get();

        $availableFormations = Formation::where('is_published', true)
            ->whereNotIn('id', $enrollments->pluck('formation_id'))
            ->take(3)
            ->get();

        return view('dashboard.index', compact(
            'user',
            'enrollments',
            'totalEnrollments',
            'completedFormations',
            'avgProgress',
            'userProjects',
            'notifications',
            'availableFormations'
        ));
    }

    public function courses()
    {
        $user = Auth::user();

        $myEnrollments = Enrollment::where('user_id', $user->id)
            ->with(['formation.modules.courses'])
            ->get();

        $enrolledIds = $myEnrollments->pluck('formation_id');

        $otherFormations = Formation::where('is_published', true)
            ->whereNotIn('id', $enrolledIds)
            ->withCount('modules')
            ->get();

        return view('dashboard.courses', compact('user', 'myEnrollments', 'otherFormations'));
    }

    public function enroll($formationId)
    {
        $user = Auth::user();
        $formation = Formation::findOrFail($formationId);

        $exists = Enrollment::where('user_id', $user->id)
            ->where('formation_id', $formation->id)
            ->exists();

        if (! $exists) {
            Enrollment::create([
                'user_id' => $user->id,
                'formation_id' => $formation->id,
                'progress_percent' => 0,
                'status' => 'active',
                'enrolled_at' => now(),
            ]);

            $formation->increment('students_count');

            Notification::create([
                'user_id' => $user->id,
                'title' => 'Nouvelle inscription',
                'message' => "Vous vous êtes inscrit avec succès à la formation {$formation->title}.",
                'type' => 'success',
            ]);
        }

        return redirect()->route('dashboard.learn', ['formationId' => $formation->id])
            ->with('success', "Inscription réussie à {$formation->title} !");
    }

    public function learnCourse($formationId, $courseId = null)
    {
        $user = Auth::user();

        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('formation_id', $formationId)
            ->with(['formation.modules.courses'])
            ->firstOrFail();

        $formation = $enrollment->formation;
        $allCourses = collect();

        foreach ($formation->modules as $module) {
            foreach ($module->courses as $c) {
                $allCourses->push($c);
            }
        }

        $activeCourse = null;
        if ($courseId) {
            $activeCourse = Course::where('id', $courseId)->first();
        }

        if (! $activeCourse && $allCourses->count() > 0) {
            $activeCourse = $allCourses->first();
        }

        $completedCourseIds = Progress::where('user_id', $user->id)
            ->whereIn('course_id', $allCourses->pluck('id'))
            ->pluck('course_id')
            ->toArray();

        return view('dashboard.learn', compact('user', 'enrollment', 'formation', 'allCourses', 'activeCourse', 'completedCourseIds'));
    }

    public function markLessonComplete(Request $request, $courseId)
    {
        $user = Auth::user();
        $course = Course::with('module.formation')->findOrFail($courseId);
        $formation = $course->module->formation;

        Progress::firstOrCreate(
            ['user_id' => $user->id, 'course_id' => $course->id],
            ['completed' => true, 'completed_at' => now()]
        );

        // Recalculate enrollment progress
        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('formation_id', $formation->id)
            ->first();

        if ($enrollment) {
            $totalCoursesInFormation = Course::whereHas('module', function ($q) use ($formation) {
                $q->where('formation_id', $formation->id);
            })->count();

            $completedInFormation = Progress::where('user_id', $user->id)
                ->whereHas('course.module', function ($q) use ($formation) {
                    $q->where('formation_id', $formation->id);
                })->count();

            $percentage = $totalCoursesInFormation > 0 ? min(100, round(($completedInFormation / $totalCoursesInFormation) * 100)) : 100;

            $enrollment->update([
                'progress_percent' => $percentage,
                'status' => $percentage >= 100 ? 'completed' : 'active',
                'completed_at' => $percentage >= 100 ? now() : null,
            ]);
        }

        return redirect()->back()->with('success', 'Leçon marquée comme terminée ! Félicitations pour votre progression.');
    }

    public function projects()
    {
        $user = Auth::user();
        $projects = Project::where('user_id', $user->id)->latest()->get();

        return view('dashboard.projects', compact('user', 'projects'));
    }

    public function storeProject(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'domain' => ['required', 'string', 'max:100'],
            'technologies' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:20', 'max:5000'],
            'github_url' => ['nullable', 'url', 'max:2048', 'regex:/^https?:\\/\\//i'],
            'demo_url' => ['nullable', 'url', 'max:2048', 'regex:/^https?:\\/\\//i'],
        ]);

        Project::create([
            'user_id' => $user->id,
            'author_name' => $user->name,
            'title' => $validated['title'],
            'domain' => $validated['domain'],
            'technologies' => $validated['technologies'],
            'description' => $validated['description'],
            'github_url' => $validated['github_url'] ?? null,
            'demo_url' => $validated['demo_url'] ?? null,
            'image_path' => 'images/code.jpg',
            'is_approved' => false,
            'is_featured' => false,
        ]);

        return redirect()->back()->with('success', 'Votre projet a été envoyé à l’administration pour validation avant publication.');
    }

    public function profile()
    {
        $user = Auth::user();

        return view('dashboard.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'bio' => 'nullable|string',
            'phone' => 'nullable|string|max:50',
            'specialization' => 'nullable|string|max:255',
            'github_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->bio = $request->bio;
        $user->phone = $request->phone;
        $user->specialization = $request->specialization;
        $user->github_url = $request->github_url;
        $user->linkedin_url = $request->linkedin_url;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Votre profil a été mis à jour avec succès.');
    }
}
