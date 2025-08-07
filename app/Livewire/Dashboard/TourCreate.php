<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Collection;
use App\Livewire\Dashboard\Tours\Forms\CreateForm;

class TourCreate extends Component
{
    use WithFileUploads;

    public CreateForm $form;

    public function mount()
    {
    }

    public function save()
    {
        $this->authorize('create', Tour::class);

        $this->validate();

        $tour = $this->form->save();

        return redirect()->route('dashboard.tours.edit', $tour);
    }

    public function render()
    {
        return view('livewire.dashboard.tours.create', []);
    }
}
