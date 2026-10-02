<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommunityPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_community_page_lists_upcoming_events_but_not_past_events(): void
    {
        $this->travelTo('2026-09-30 12:00:00');

        $this->createEvent('Hackathon panafricain', '2026-10-15');
        $this->createEvent('Rencontre à programmer', null);
        $this->createEvent('Atelier passé', '2026-09-20');

        $this->get(route('community'))
            ->assertSee('Une communauté qui fait avancer le numérique africain.')
            ->assertSee('Hackathon panafricain')
            ->assertSee('Rencontre à programmer')
            ->assertDontSee('Atelier passé')
            ->assertSee('bg-[#f6f3eb] text-[#18382b]', false);
    }

    public function test_community_page_explains_when_no_events_are_scheduled(): void
    {
        $this->get(route('community'))
            ->assertSee('Les prochains rendez-vous se préparent.')
            ->assertSee('Aucun événement n’est programmé pour le moment.')
            ->assertSee(route('membership.create'), false);
    }

    public function test_community_page_escapes_untrusted_event_content(): void
    {
        $this->travelTo('2026-09-30 12:00:00');
        $this->createEvent(
            '<script>alert(1)</script>',
            '2026-10-15',
            '<img src=x onerror=alert(1)>',
        );

        $this->get(route('community'))
            ->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false)
            ->assertSee('&lt;img src=x onerror=alert(1)&gt;', false)
            ->assertDontSee('<script>alert(1)</script>', false)
            ->assertDontSee('<img src=x onerror=alert(1)>', false);
    }

    public function test_community_page_shows_featured_testimonials_and_join_links(): void
    {
        Testimonial::create([
            'name' => 'Aïssatou Fall',
            'role_title' => 'Ingénieure logicielle',
            'content' => 'La communauté ouvre de nouvelles perspectives de collaboration.',
            'rating' => 5,
            'is_featured' => true,
        ]);
        Testimonial::create([
            'name' => 'Mamadou Diallo',
            'role_title' => 'Développeur',
            'content' => 'Ce témoignage ne doit pas être affiché.',
            'rating' => 4,
            'is_featured' => false,
        ]);

        $this->get(route('community'))
            ->assertSee('Aïssatou Fall')
            ->assertSee('Ingénieure logicielle')
            ->assertSee('La communauté ouvre de nouvelles perspectives de collaboration.')
            ->assertDontSee('Ce témoignage ne doit pas être affiché.')
            ->assertSee(route('membership.create'), false)
            ->assertSee(route('contribute'), false);
    }

    private function createEvent(
        string $title,
        ?string $eventDate,
        string $description = 'Une activité ouverte à la communauté.',
    ): Event {
        return Event::create([
            'title' => $title,
            'type' => 'Hackathon',
            'event_date' => $eventDate,
            'event_time' => '10:00 GMT',
            'location' => 'Dakar et en ligne',
            'description' => $description,
            'is_featured' => true,
        ]);
    }
}
