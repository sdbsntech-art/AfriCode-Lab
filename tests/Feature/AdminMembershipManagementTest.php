<?php

namespace Tests\Feature;

use App\Models\Membership;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminMembershipManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_membership_management(): void
    {
        $this->get(route('admin.memberships'))
            ->assertRedirect(route('login'));
    }

    public function test_non_admin_cannot_manage_membership_requests(): void
    {
        $user = User::factory()->create(['role' => 'student']);

        $this->actingAs($user)
            ->get(route('admin.memberships'))
            ->assertRedirect(route('dashboard'))
            ->assertSessionHas('error');
    }

    public function test_admin_sees_real_membership_requests_on_dashboard(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $membership = $this->createMembership(
            'Nadia Ndiaye',
            'nadia@example.com',
        );

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('nadia@example.com')
            ->assertSee('Demandes d’adhésion')
            ->assertDontSee('+100%');
    }

    public function test_admin_can_search_membership_requests_and_view_contact_details(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $membership = $this->createMembership(
            'Awa Diop',
            'awa@example.com',
        );
        $this->createMembership('Moussa Ba', 'moussa@example.com');

        $this->actingAs($admin)
            ->get(route('admin.memberships', ['search' => 'awa']))
            ->assertOk()
            ->assertSee($membership->name)
            ->assertSee($membership->email)
            ->assertSee($membership->phone)
            ->assertSee($membership->expertise)
            ->assertSee('Professionnel du numérique')
            ->assertSee($membership->motivation)
            ->assertDontSee('moussa@example.com');
    }

    public function test_admin_can_filter_membership_requests_by_status(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $pendingMembership = $this->createMembership('Awa Diop', 'awa@example.com');
        $approvedMembership = $this->createMembership('Moussa Ba', 'moussa@example.com');
        $approvedMembership->status = 'approved';
        $approvedMembership->save();

        $this->actingAs($admin)
            ->get(route('admin.memberships', ['status' => 'approved']))
            ->assertOk()
            ->assertSee($approvedMembership->email)
            ->assertDontSee($pendingMembership->email);
    }

    public function test_admin_can_approve_a_membership_request_and_save_notes(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $membership = $this->createMembership('Awa Diop', 'awa@example.com');

        $this->actingAs($admin)
            ->post(route('admin.memberships.status', $membership), [
                'status' => 'approved',
                'admin_notes' => 'Profil validé après examen.',
            ])
            ->assertRedirect(route('admin.memberships'));

        $membership->refresh();

        $this->assertDatabaseHas('memberships', [
            'id' => $membership->id,
            'status' => 'approved',
            'admin_notes' => 'Profil validé après examen.',
        ]);
        $this->assertNotNull($membership->reviewed_at);
    }

    public function test_admin_can_reject_a_membership_request(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $membership = $this->createMembership('Awa Diop', 'awa@example.com');

        $this->actingAs($admin)
            ->post(route('admin.memberships.status', $membership), [
                'status' => 'rejected',
                'admin_notes' => 'Informations complémentaires nécessaires.',
            ])
            ->assertRedirect(route('admin.memberships'));

        $this->assertDatabaseHas('memberships', [
            'id' => $membership->id,
            'status' => 'rejected',
            'admin_notes' => 'Informations complémentaires nécessaires.',
        ]);
        $this->assertNotNull($membership->refresh()->reviewed_at);
    }

    public function test_invalid_membership_status_does_not_change_the_request(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $membership = $this->createMembership('Awa Diop', 'awa@example.com');

        $this->actingAs($admin)
            ->from(route('admin.memberships'))
            ->post(route('admin.memberships.status', $membership), [
                'status' => 'published',
                'admin_notes' => 'Ne doit pas être enregistré.',
            ])
            ->assertRedirect(route('admin.memberships'))
            ->assertSessionHasErrors('status');

        $this->assertDatabaseHas('memberships', [
            'id' => $membership->id,
            'status' => 'pending',
            'admin_notes' => null,
            'reviewed_at' => null,
        ]);
    }

    private function createMembership(string $name, string $email): Membership
    {
        $membership = Membership::create([
            'name' => $name,
            'email' => $email,
            'phone' => '+221 77 123 45 67',
            'membership_type' => 'professional',
            'expertise' => 'Développement web',
            'motivation' => 'Je souhaite contribuer aux projets numériques africains.',
        ]);

        return $membership;
    }
}
