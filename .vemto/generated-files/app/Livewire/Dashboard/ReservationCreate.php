<?php

namespace App\Livewire\Dashboard;

use App\Models\User;
use App\Models\Tour;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Collection;
use App\Livewire\Dashboard\Reservations\Forms\CreateForm;

class ReservationCreate extends Component
{
    use WithFileUploads;

    public CreateForm $form;
    public Collection $users;
    public Collection $tours;

    public function mount()
    {
        $this->users = User::pluck('name', 'id');
        $this->tours = Tour::pluck('title', 'id');
    }

    public function save()
    {
        $this->authorize('create', Reservation::class);

        $this->validate();

        $reservation = $this->form->save();

        return redirect()->route('dashboard.reservations.edit', $reservation);
    }

    public function render()
    {
        return view('livewire.dashboard.reservations.create', []);
    }
}
