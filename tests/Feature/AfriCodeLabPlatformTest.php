<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Formation;
use App\Models\Module;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AfriCodeLabPlatformTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create initial test formation
        $formation = Formation::create([
            'title' => 'Développement Web Full-Stack Moderne',
            'slug' => 'developpement-web-fullstack',
            'domain' => 'dev',
            'icon' => 'code',
            'badge' => 'Populaire',
            'summary' => 'Maîtrisez HTML5, CSS3, JavaScript, PHP, Laravel et MySQL.',
            'description' => 'Formation complète pour devenir développeur web opérationnel.',
            'level' => 'Débutant à Intermédiaire',
            'duration' => '6 mois (intensif)',
            'is_featured' => true,
            'is_published' => true,
        ]);

        $module = Module::create([
            'formation_id' => $formation->id,
            'title' => 'Module 1 : Les Fondations du Web',
            'description' => 'Architecture client-serveur, HTTP, HTML5 sémantique.',
            'order' => 1,
        ]);

        Course::create([
            'module_id' => $module->id,
            'title' => 'Introduction au Web & Architecture Client-Serveur',
            'content' => 'Comprendre le fonctionnement d’Internet et du protocole HTTP.',
            'duration' => '45 min',
            'is_free_preview' => true,
            'order' => 1,
        ]);
    }

    /** Test public pages */
    public function test_public_pages_load_successfully(): void
    {
        $routes = [
            '/',
            '/about',
            '/formations',
            '/formations/developpement-web-fullstack',
            '/parcours',
            '/projets',
            '/communaute',
            '/contribuer',
            '/contact',
            '/login',
            '/register',
        ];

        foreach ($routes as $route) {
            $response = $this->get($route);
            $response->assertStatus(200);
        }
    }

    /** Test user registration */
    public function test_user_registration(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test Student',
            'email' => 'newstudent@example.com',
            'password' => 'SecurePass123!',
            'password_confirmation' => 'SecurePass123!',
            'specialization' => 'Développement Web',
            'terms' => 'on',
        ]);

        $response->assertRedirect(route('verification.notice'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['email' => 'newstudent@example.com', 'role' => 'student']);
    }

    /** Test user login and role-based redirect */
    public function test_user_login(): void
    {
        $user = User::factory()->create([
            'email' => 'existing@example.com',
            'password' => bcrypt('Secret123!'),
            'role' => 'student',
            'is_active' => true,
        ]);

        $response = $this->post('/login', [
            'email' => 'existing@example.com',
            'password' => 'Secret123!',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    /** Test course enrollment and lesson completion */
    public function test_student_enrollment_and_learning(): void
    {
        $student = User::factory()->create([
            'role' => 'student',
            'is_active' => true,
        ]);

        $formation = Formation::first();
        $course = Course::first();

        // 1. Enroll
        $response = $this->actingAs($student)->post("/dashboard/enroll/{$formation->id}");
        $response->assertRedirect(route('dashboard.learn', ['formationId' => $formation->id]));
        $this->assertDatabaseHas('enrollments', [
            'user_id' => $student->id,
            'formation_id' => $formation->id,
        ]);

        // 2. Access learning environment
        $response = $this->actingAs($student)->get("/dashboard/learn/{$formation->id}/{$course->id}");
        $response->assertStatus(200);
        $response->assertSee($course->title);

        // 3. Mark lesson complete
        $response = $this->actingAs($student)->post("/dashboard/complete-lesson/{$course->id}");
        $response->assertRedirect();
        $this->assertDatabaseHas('progress', [
            'user_id' => $student->id,
            'course_id' => $course->id,
            'completed' => true,
        ]);
    }

    /** Test student project submission */
    public function test_student_can_submit_project(): void
    {
        $student = User::factory()->create([
            'role' => 'student',
            'is_active' => true,
        ]);

        $response = $this->actingAs($student)->post('/dashboard/projects', [
            'title' => 'AfriHealth App',
            'description' => 'Plateforme de télémédecine pour zones rurales.',
            'technologies' => 'Laravel, Vue, Tailwind',
            'domain' => 'Santé & IA',
            'github_url' => 'https://github.com/test/afrihealth',
        ]);

        $response
            ->assertRedirect()
            ->assertSessionHas('success', 'Votre projet a été envoyé à l’administration pour validation avant publication.');
        $this->assertDatabaseHas('projects', [
            'title' => 'AfriHealth App',
            'user_id' => $student->id,
            'is_approved' => false,
        ]);
    }

    /** Test admin access control and admin operations */
    public function test_admin_access_control(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $admin = User::factory()->create(['role' => 'admin']);

        // Student cannot access admin dashboard -> redirected to student dashboard
        $response = $this->actingAs($student)->get('/admin');
        $response->assertRedirect(route('dashboard'));

        // Admin can access admin dashboard
        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);
    }
}
