<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Collection;
use App\Livewire\Dashboard\Categories\Forms\UpdateForm;

class CategoryEdit extends Component
{
    public ?Category $category = null;

    public UpdateForm $form;

    public function mount(Category $category)
    {
        $this->authorize('view-any', Category::class);

        $this->category = $category;

        $this->form->setCategory($category);
    }

    public function save()
    {
        $this->authorize('update', $this->category);

        $this->validate();

        $this->form->save();

        $this->dispatch('saved');
    }

    public function render()
    {
        return view('livewire.dashboard.categories.edit', []);
    }
}
