<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Collection;
use App\Livewire\Dashboard\Categories\Forms\CreateForm;

class CategoryCreate extends Component
{
    use WithFileUploads;

    public CreateForm $form;

    public function mount()
    {
    }

    public function save()
    {
        $this->authorize('create', Category::class);

        $this->validate();

        $category = $this->form->save();

        return redirect()->route('dashboard.categories.edit', $category);
    }

    public function render()
    {
        return view('livewire.dashboard.categories.create', []);
    }
}
