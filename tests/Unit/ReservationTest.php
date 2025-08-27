<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Tour;
use App\Models\Reservation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_store_reservation_and_is_redirected_to_login()
    {
        $tour = Tour::factory()->create(['max_participants' => 10]);

        $res = $this->post(route('reservation.store', $tour), [
            'number_of_people' => 2,
        ]);

        $res->assertRedirect(route('login'));
        $this->assertDatabaseCount('reservations', 0);
    }

    public function test_it_shows_create_form_and_calculates_available()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->createOne();
        $tour = Tour::factory()->create(['max_participants' => 10]);

        Reservation::factory()->create([
            'tour_id' => $tour->id, 'status' => 'placed', 'number_of_people' => 3,
        ]);
        Reservation::factory()->create([
            'tour_id' => $tour->id, 'status' => 'confirmed', 'number_of_people' => 2,
        ]);
        Reservation::factory()->create([
            'tour_id' => $tour->id, 'status' => 'canceled', 'number_of_people' => 4,
        ]);

        $this->actingAs($user);
        $res = $this->get(route('reservation.create', $tour));

        $res->assertOk()
            ->assertViewIs('reservations.create')
            ->assertViewHasAll(['tour', 'reserved', 'available']);

        $viewData = $res->original->getData();
        $this->assertEquals(5, $viewData['reserved']);
        $this->assertEquals(5, $viewData['available']);
    }

    public function test_user_can_store_reservation_when_capacity_allows()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->createOne();
        $tour = Tour::factory()->create(['max_participants' => 8]);

        Reservation::factory()->create([
            'tour_id' => $tour->id, 'status' => 'confirmed', 'number_of_people' => 3,
        ]);

        $this->actingAs($user);
        $res = $this->post(route('reservation.store', $tour), [
            'number_of_people' => 4,
        ]);

        $res->assertRedirect(route('homepage'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('reservations', [
            'user_id' => $user->id,
            'tour_id' => $tour->id,
            'status' => 'placed',
            'number_of_people' => 4,
        ]);
    }

    public function test_store_fails_when_capacity_would_be_exceeded()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->createOne();
        $tour = Tour::factory()->create(['max_participants' => 6]);

        Reservation::factory()->create([
            'tour_id' => $tour->id, 'status' => 'placed', 'number_of_people' => 5,
        ]);

        $this->actingAs($user);
        $res = $this->from(route('reservation.create', $tour))
            ->post(route('reservation.store', $tour), [
                'number_of_people' => 2,
            ]);

        $res->assertSessionHasErrors('number_of_people');
        $this->assertDatabaseCount('reservations', 1);
    }

    public function test_canceled_reservation_frees_capacity_for_future_bookings()
    {
        /** @var \App\Models\User $owner */
        $owner = User::factory()->createOne();
        /** @var \App\Models\User $another */
        $another = User::factory()->createOne();
        $tour = Tour::factory()->create(['max_participants' => 4]);

        $placed = Reservation::factory()->create([
            'user_id' => $owner->id,
            'tour_id' => $tour->id,
            'status' => 'placed',
            'number_of_people' => 3,
        ]);

        $this->actingAs($another);
        $this->from(route('reservation.create', $tour))
            ->post(route('reservation.store', $tour), ['number_of_people' => 2])
            ->assertSessionHasErrors('number_of_people');

        $this->actingAs($owner);
        $this->post(route('reservation.cancel', $placed))
            ->assertSessionHas('success');

        $this->actingAs($another);
        $this->post(route('reservation.store', $tour), ['number_of_people' => 2])
            ->assertRedirect(route('homepage'));

        $this->assertDatabaseHas('reservations', [
            'user_id' => $another->id,
            'tour_id' => $tour->id,
            'number_of_people' => 2,
            'status' => 'placed',
        ]);
    }
}
