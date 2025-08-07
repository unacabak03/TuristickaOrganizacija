<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Collection;
use App\Livewire\Dashboard\Users\Forms\CreateForm;

class UserCreate extends Component
{
    use WithFileUploads;

    public CreateForm $form;

    public function mount()
    {
    }

    public function save()
    {
        $this->authorize('create', User::class);

        $this->validate();

        $user = $this->form->save();

        return redirect()->route('dashboard.users.edit', $user);
    }

    public function render()
    {
        return view('livewire.dashboard.users.create', []);
    }
}
