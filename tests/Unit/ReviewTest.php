<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Tour;
use App\Models\Reservation;
use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_access_review_create_if_not_owner_or_not_confirmed()
    {
        /** @var \App\Models\User $owner */
        $owner = User::factory()->createOne();
        /** @var \App\Models\User $other */
        $other = User::factory()->createOne();
        $tour = Tour::factory()->create();

        $reservation = Reservation::factory()->create([
            'user_id' => $owner->id,
            'tour_id' => $tour->id,
            'status' => 'placed',
        ]);

        $this->actingAs($other);
        $this->get(route('reservation.review.create', $reservation))
            ->assertForbidden();

        $this->actingAs($owner);
        $this->get(route('reservation.review.create', $reservation))
            ->assertStatus(422);
    }

    public function test_user_can_access_review_create_for_confirmed_reservation()
    {
        /** @var \App\Models\User $owner */
        $owner = User::factory()->createOne();
        $tour = Tour::factory()->create();

        $reservation = Reservation::factory()->create([
            'user_id' => $owner->id,
            'tour_id' => $tour->id,
            'status' => 'confirmed',
        ]);

        $this->actingAs($owner);
        $this->get(route('reservation.review.create', $reservation))
            ->assertOk()
            ->assertViewIs('reservations.review')
            ->assertViewHasAll(['reservation', 'tour', 'review']);
    }

    public function test_review_store_requires_valid_payload_and_confirmed_status()
    {
        /** @var \App\Models\User $owner */
        $owner = User::factory()->createOne();
        $tour = Tour::factory()->create();

        $reservation = Reservation::factory()->create([
            'user_id' => $owner->id,
            'tour_id' => $tour->id,
            'status' => 'confirmed',
        ]);

        $this->actingAs($owner);

        $this->from(route('reservation.review.create', $reservation))
            ->post(route('reservation.review', $reservation), [
                'rating' => 6,
                'comment' => '',
            ])->assertSessionHasErrors(['rating', 'comment']);

        $this->post(route('reservation.review', $reservation), [
            'rating' => 5,
            'comment' => 'Odlična tura!',
        ])->assertRedirect(route('reservation.index'))
          ->assertSessionHas('success');

        $this->assertDatabaseHas('reviews', [
            'user_id' => $owner->id,
            'tour_id' => $tour->id,
            'rating'  => 5,
            'comment' => 'Odlična tura!',
        ]);
    }

    public function test_review_store_updates_existing_review_instead_of_creating_duplicate()
    {
        /** @var \App\Models\User $owner */
        $owner = User::factory()->createOne();
        $tour = Tour::factory()->create();

        $reservation = Reservation::factory()->create([
            'user_id' => $owner->id,
            'tour_id' => $tour->id,
            'status' => 'confirmed',
        ]);

        Review::factory()->create([
            'user_id' => $owner->id,
            'tour_id' => $tour->id,
            'rating'  => 3,
            'comment' => 'Ok.',
        ]);

        $this->actingAs($owner);
        $this->post(route('reservation.review', $reservation), [
            'rating' => 4,
            'comment' => 'Bolje nego prošli put.',
        ])->assertRedirect(route('reservation.index'));

        $this->assertDatabaseCount('reviews', 1);
        $this->assertDatabaseHas('reviews', [
            'user_id' => $owner->id,
            'tour_id' => $tour->id,
            'rating'  => 4,
            'comment' => 'Bolje nego prošli put.',
        ]);
    }

    public function test_non_owner_or_not_confirmed_cannot_store_review()
    {
        /** @var \App\Models\User $owner */
        $owner = User::factory()->createOne();
        /** @var \App\Models\User $other */
        $other = User::factory()->createOne();
        $tour = Tour::factory()->create();

        $reservationPlaced = Reservation::factory()->create([
            'user_id' => $owner->id,
            'tour_id' => $tour->id,
            'status' => 'placed',
        ]);

        $this->actingAs($other);
        $this->post(route('reservation.review', $reservationPlaced), [
            'rating' => 5, 'comment' => 'x',
        ])->assertForbidden();

        $this->actingAs($owner);
        $this->post(route('reservation.review', $reservationPlaced), [
            'rating' => 5, 'comment' => 'x',
        ])->assertStatus(422);

        $this->assertDatabaseCount('reviews', 0);
    }
}
