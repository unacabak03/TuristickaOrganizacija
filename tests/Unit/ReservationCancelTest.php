<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Tour;
use App\Models\Reservation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservationCancelTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_owner_can_cancel_their_reservation()
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
            'number_of_people' => 2,
        ]);

        $this->actingAs($other);
        $this->post(route('reservation.cancel', $reservation))
            ->assertForbidden();

        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'status' => 'placed',
        ]);

        $this->actingAs($owner);
        $this->post(route('reservation.cancel', $reservation))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'status' => 'canceled',
        ]);
    }

    public function test_cancel_is_idempotent_returns_message_if_already_canceled()
    {
        /** @var \App\Models\User $owner */
        $owner = User::factory()->createOne();
        $tour = Tour::factory()->create();

        $reservation = Reservation::factory()->create([
            'user_id' => $owner->id,
            'tour_id' => $tour->id,
            'status' => 'canceled',
        ]);

        $this->actingAs($owner);
        $this->post(route('reservation.cancel', $reservation))
            ->assertSessionHas('success');
    }
}
