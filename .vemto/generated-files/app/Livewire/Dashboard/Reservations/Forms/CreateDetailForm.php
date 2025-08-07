<?php

namespace App\Livewire\Dashboard\Reservations\Forms;

use Livewire\Form;
use App\Models\Reservation;
use Livewire\Attributes\Rule;

class CreateDetailForm extends Form
{
    public $tour_id = null;

    #[Rule('required')]
    public $user_id = '';

    #[Rule('required')]
    public $status = '';

    #[Rule('required')]
    public $number_of_people = '';

    public function save()
    {
        $this->validate();

        $reservation = Reservation::create($this->except([]));

        $this->reset();

        return $reservation;
    }
}
