<?php

namespace App\Livewire\Dashboard;

use App\Models\User;
use App\Models\Tour;
use Livewire\Component;
use App\Models\Reservation;
use Illuminate\Support\Collection;
use App\Livewire\Dashboard\Reservations\Forms\UpdateForm;

class ReservationEdit extends Component
{
    public ?Reservation $reservation = null;

    public UpdateForm $form;
    public Collection $users;
    public Collection $tours;

    public function mount(Reservation $reservation)
    {
        $this->authorize('view-any', Reservation::class);

        $this->reservation = $reservation;

        $this->form->setReservation($reservation);
        $this->users = User::pluck('name', 'id');
        $this->tours = Tour::pluck('title', 'id');
    }

    public function save()
    {
        $this->authorize('update', $this->reservation);

        $this->validate();

        $this->form->save();

        $this->dispatch('saved');
    }

    public function render()
    {
        return view('livewire.dashboard.reservations.edit', []);
    }
}
