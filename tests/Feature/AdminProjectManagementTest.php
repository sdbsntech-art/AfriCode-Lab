<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Database\Seeders\FeaturedProjectsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminProjectManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_open_project_administration(): void
    {
        $this->get(route('admin.projects'))
            ->assertRedirectToRoute('login');
    }

    public function test_student_cannot_add_a_project_from_project_administration(): void
    {
        $student = User::factory()->create(['role' => 'student']);

        $this->actingAs($student)
            ->post(route('admin.projects.store'), [])
            ->assertRedirectToRoute('dashboard');

        $this->assertDatabaseCount('projects', 0);
    }

    public function test_admin_sees_the_project_creation_form_and_publication_workflow(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get(route('admin.projects'))
            ->assertSee('Nouveau projet à présenter')
            ->assertSee('Visuel du projet')
            ->assertSee('Les projets créés ici restent en attente jusqu’à votre validation.');
    }

    public function test_admin_can_add_a_project_for_review_with_a_valid_image(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)
            ->post(route('admin.projects.store'), [
                ...$this->validProjectData(),
                'image' => UploadedFile::fake()->image('mockup.png', 1200, 800),
                'is_featured' => '1',
            ]);

        $response
            ->assertRedirectToRoute('admin.projects')
            ->assertSessionHas('success');

        $project = Project::where('title', 'Gestion maraîchère')->firstOrFail();

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'author_name' => 'Awa Diop',
            'is_approved' => false,
            'is_featured' => true,
        ]);
        Storage::disk('public')->assertExists($project->image_path);
    }

    public function test_admin_cannot_upload_an_active_svg_as_a_project_image(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->from(route('admin.projects'))
            ->post(route('admin.projects.store'), [
                ...$this->validProjectData(),
                'image' => UploadedFile::fake()->create('payload.svg', 1, 'image/svg+xml'),
            ])
            ->assertRedirectToRoute('admin.projects')
            ->assertSessionHasErrors('image');

        $this->assertDatabaseMissing('projects', [
            'title' => 'Gestion maraîchère',
        ]);
        $this->assertSame([], Storage::disk('public')->allFiles('projects'));
    }

    public function test_admin_cannot_add_a_project_with_a_non_http_demo_url(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->from(route('admin.projects'))
            ->post(route('admin.projects.store'), [
                ...$this->validProjectData(),
                'demo_url' => 'javascript://example.com',
                'image' => UploadedFile::fake()->image('mockup.png', 1200, 800),
            ])
            ->assertRedirectToRoute('admin.projects')
            ->assertSessionHasErrors('demo_url');

        $this->assertDatabaseMissing('projects', [
            'title' => 'Gestion maraîchère',
        ]);
        $this->assertSame([], Storage::disk('public')->allFiles('projects'));
    }

    public function test_admin_can_approve_and_publish_a_pending_project(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $project = Project::create([
            ...$this->validProjectData(),
            'author_name' => 'Awa Diop',
            'is_approved' => false,
        ]);

        $this->actingAs($admin)
            ->post(route('admin.projects.approve', $project))
            ->assertRedirect();

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'is_approved' => true,
        ]);
    }

    public function test_public_gallery_shows_only_approved_projects_and_uses_domain_filter(): void
    {
        Project::create([
            ...$this->validProjectData(),
            'title' => 'Projet publié',
            'author_name' => 'Seydou Bakhayokho',
            'is_approved' => true,
        ]);
        Project::create([
            ...$this->validProjectData(),
            'title' => 'Projet en attente',
            'author_name' => 'Auteur',
            'is_approved' => false,
        ]);

        $this->get(route('projects', ['domain' => 'Agriculture']))
            ->assertSee('Projet publié')
            ->assertDontSee('Projet en attente');
    }

    public function test_public_gallery_escapes_project_content_and_treats_filter_as_a_value(): void
    {
        Project::create([
            ...$this->validProjectData(),
            'title' => '<script>alert(1)</script>',
            'description' => '<img src=x onerror=alert(1)>',
            'author_name' => 'Seydou Bakhayokho',
            'is_approved' => true,
        ]);

        $this->get(route('projects'))
            ->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false)
            ->assertSee('&lt;img src=x onerror=alert(1)&gt;', false)
            ->assertDontSee('<script>alert(1)</script>', false)
            ->assertDontSee('<img src=x onerror=alert(1)>', false);

        $this->get(route('projects', ['domain' => "' OR 1=1 --"]))
            ->assertSee('Aucun projet dans ce domaine pour le moment.')
            ->assertDontSee('&lt;script&gt;alert(1)&lt;/script&gt;', false);
    }

    public function test_curated_projects_are_seeded_with_the_requested_links_and_original_mockups(): void
    {
        $this->seed(FeaturedProjectsSeeder::class);

        $this->get(route('projects'))
            ->assertSee('IDA Cours')
            ->assertSee('https://ida-cours.site/', false)
            ->assertSee('Le Poulailler')
            ->assertSee('https://le-poulailler-h648.vercel.app/', false)
            ->assertSee('Seydou Bakhayokho')
            ->assertSee('images/projects/ida-cours.svg', false)
            ->assertSee('images/projects/le-poulailler.svg', false);

        $this->assertDatabaseHas('projects', [
            'title' => 'IDA Cours',
            'demo_url' => 'https://ida-cours.site/',
            'author_name' => 'Seydou Bakhayokho — Étudiant développeur en informatique',
            'is_approved' => true,
        ]);
        $this->assertDatabaseHas('projects', [
            'title' => 'Le Poulailler',
            'demo_url' => 'https://le-poulailler-h648.vercel.app/',
            'is_approved' => true,
        ]);
    }

    private function validProjectData(): array
    {
        return [
            'title' => 'Gestion maraîchère',
            'description' => 'Une application pour assurer le suivi des activités et des produits.',
            'domain' => 'Agriculture',
            'technologies' => 'Application web',
            'author_name' => 'Awa Diop',
            'demo_url' => 'https://example.com',
            'github_url' => 'https://github.com/example/project',
        ];
    }
}
