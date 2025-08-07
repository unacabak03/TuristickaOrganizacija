<?php

namespace App\Livewire\Dashboard;

use App\Models\Tour;
use Livewire\Component;
use Illuminate\Support\Collection;
use App\Livewire\Dashboard\Tours\Forms\UpdateForm;

class TourEdit extends Component
{
    public ?Tour $tour = null;

    public UpdateForm $form;

    public function mount(Tour $tour)
    {
        $this->authorize('view-any', Tour::class);

        $this->tour = $tour;

        $this->form->setTour($tour);
    }

    public function save()
    {
        $this->authorize('update', $this->tour);

        $this->validate();

        $this->form->save();

        $this->dispatch('saved');
    }

    public function render()
    {
        return view('livewire.dashboard.tours.edit', []);
    }
}
