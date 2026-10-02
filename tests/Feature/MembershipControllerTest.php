<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MembershipControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_membership_request_is_saved_as_pending(): void
    {
        $response = $this->post(route('membership.store'), [
            'name' => 'Amina Diallo',
            'email' => 'amina@example.com',
            'phone' => '+221 77 000 00 00',
            'membership_type' => 'professional',
            'expertise' => 'Développement web',
            'motivation' => 'Je souhaite contribuer aux projets numériques africains.',
        ]);

        $response
            ->assertRedirect(route('membership.create'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('memberships', [
            'user_id' => null,
            'name' => 'Amina Diallo',
            'email' => 'amina@example.com',
            'membership_type' => 'professional',
            'status' => 'pending',
        ]);
    }

    public function test_authenticated_membership_request_is_linked_to_the_user(): void
    {
        $user = User::factory()->create([
            'name' => 'Moussa Ba',
            'email' => 'moussa@example.com',
        ]);

        $response = $this->actingAs($user)->post(route('membership.store'), [
            'name' => 'Moussa Ba',
            'email' => 'moussa@example.com',
            'membership_type' => 'member',
            'motivation' => 'Je souhaite participer aux initiatives de AfriCode Lab.',
        ]);

        $response->assertRedirect(route('membership.create'));

        $this->assertDatabaseHas('memberships', [
            'user_id' => $user->id,
            'email' => 'moussa@example.com',
            'membership_type' => 'member',
            'status' => 'pending',
        ]);
    }

    public function test_invalid_membership_request_is_rejected_without_saving(): void
    {
        $response = $this->post(route('membership.store'), [
            'email' => 'not-an-email',
            'membership_type' => 'unknown',
            'motivation' => 'Trop court',
        ]);

        $response->assertSessionHasErrors([
            'name',
            'email',
            'membership_type',
            'motivation',
        ]);

        $this->assertDatabaseMissing('memberships', [
            'email' => 'not-an-email',
        ]);
    }

    public function test_membership_form_is_publicly_available(): void
    {
        $this->get(route('membership.create'))
            ->assertOk()
            ->assertSee('Adhérer à AfriCode Lab');
    }
}
