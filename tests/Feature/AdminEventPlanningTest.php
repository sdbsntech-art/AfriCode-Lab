<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminEventPlanningTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_lists_only_events_that_are_upcoming_or_unscheduled(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $upcomingEvent = $this->createEvent(
            'Hackathon panafricain',
            now()->addDays(12)->toDateString(),
        );
        $unscheduledEvent = $this->createEvent('Atelier de préparation', null);
        $pastEvent = $this->createEvent(
            'Rencontre terminée',
            now()->subDays(2)->toDateString(),
        );

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee($upcomingEvent->title)
            ->assertSee($unscheduledEvent->title)
            ->assertDontSee($pastEvent->title);
    }

    public function test_admin_can_plan_a_hackathon_from_the_dashboard(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $eventDate = now()->addDays(30)->toDateString();

        $this->actingAs($admin)
            ->from(route('admin.dashboard'))
            ->post(route('admin.events.store'), [
                'title' => 'Hackathon AfriCode',
                'type' => 'Hackathon',
                'event_date' => $eventDate,
                'event_time' => '09:00 GMT',
                'location' => 'Dakar et en ligne',
                'description' => 'Deux jours pour concevoir des solutions numériques utiles.',
                'registration_url' => 'https://example.com/inscription',
            ])
            ->assertRedirect(route('admin.dashboard'));

        $this->assertDatabaseHas('events', [
            'title' => 'Hackathon AfriCode',
            'type' => 'Hackathon',
            'event_time' => '09:00 GMT',
            'location' => 'Dakar et en ligne',
            'registration_url' => 'https://example.com/inscription',
        ]);
        $this->assertSame(
            $eventDate,
            Event::where('title', 'Hackathon AfriCode')->firstOrFail()->event_date->toDateString(),
        );
    }

    public function test_admin_cannot_schedule_a_new_event_in_the_past(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->from(route('admin.dashboard'))
            ->post(route('admin.events.store'), [
                'title' => 'Ancien événement',
                'type' => 'Conférence',
                'event_date' => now()->subDay()->toDateString(),
                'event_time' => '10:00 GMT',
                'location' => 'En ligne',
                'description' => 'Description suffisamment longue.',
            ])
            ->assertRedirect(route('admin.dashboard'))
            ->assertSessionHasErrors('event_date');

        $this->assertDatabaseMissing('events', [
            'title' => 'Ancien événement',
        ]);
    }

    public function test_admin_must_provide_a_valid_registration_url(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->from(route('admin.dashboard'))
            ->post(route('admin.events.store'), [
                'title' => 'Webinaire AfriCode',
                'type' => 'Webinaire',
                'event_date' => now()->addDays(7)->toDateString(),
                'event_time' => '18:00 GMT',
                'location' => 'En ligne',
                'description' => 'Présentation du programme de la communauté.',
                'registration_url' => 'not-a-url',
            ])
            ->assertRedirect(route('admin.dashboard'))
            ->assertSessionHasErrors('registration_url');

        $this->assertDatabaseMissing('events', [
            'title' => 'Webinaire AfriCode',
        ]);
    }

    public function test_admin_can_change_the_date_and_time_from_the_dashboard(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $event = $this->createEvent('Atelier à planifier', null);
        $eventDate = now()->addDays(20)->toDateString();

        $this->actingAs($admin)
            ->from(route('admin.dashboard'))
            ->post(route('admin.events.date', $event), [
                'event_date' => $eventDate,
                'event_time' => '14:30 GMT',
            ])
            ->assertRedirect(route('admin.dashboard'));

        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'event_time' => '14:30 GMT',
        ]);
        $this->assertSame($eventDate, $event->refresh()->event_date->toDateString());
    }

    private function createEvent(string $title, ?string $eventDate): Event
    {
        return Event::create([
            'title' => $title,
            'type' => 'Hackathon',
            'event_date' => $eventDate,
            'event_time' => '18:00 GMT',
            'location' => 'En ligne',
            'description' => 'Un événement de la communauté AfriCode Lab.',
        ]);
    }
}
