<?php

namespace App\Livewire\Dashboard\Reservations\Forms;

use Livewire\Form;
use App\Models\Reservation;
use Illuminate\Validation\Rule;

class UpdateForm extends Form
{
    public ?Reservation $reservation;

    public $user_id = '';

    public $tour_id = '';

    public $status = '';

    public $number_of_people = '';

    public function rules(): array
    {
        return [
            'user_id' => ['required'],
            'tour_id' => ['required'],
            'status' => ['required'],
            'number_of_people' => ['required'],
        ];
    }

    public function setReservation(Reservation $reservation)
    {
        $this->reservation = $reservation;

        $this->user_id = $reservation->user_id;
        $this->tour_id = $reservation->tour_id;
        $this->status = $reservation->status;
        $this->number_of_people = $reservation->number_of_people;
    }

    public function save()
    {
        $this->validate();

        $this->reservation->update(
            $this->except(['reservation', 'user_id', 'tour_id'])
        );
    }
}
