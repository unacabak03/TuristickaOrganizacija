<?php

namespace App\Livewire\Dashboard;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Collection;
use App\Livewire\Dashboard\Users\Forms\UpdateForm;

class UserEdit extends Component
{
    public ?User $user = null;

    public UpdateForm $form;

    public function mount(User $user)
    {
        $this->authorize('view-any', User::class);

        $this->user = $user;

        $this->form->setUser($user);
    }

    public function save()
    {
        $this->authorize('update', $this->user);

        $this->validate();

        $this->form->save();

        $this->dispatch('saved');
    }

    public function render()
    {
        return view('livewire.dashboard.users.edit', []);
    }
}
