<?php

namespace App\Livewire\Dashboard\Categories\Forms;

use Livewire\Form;
use App\Models\Category;
use Livewire\Attributes\Rule;

class CreateForm extends Form
{
    #[Rule('required|string')]
    public $name = '';

    #[Rule('required|string')]
    public $description = '';

    public function save()
    {
        $this->validate();

        $category = Category::create($this->except([]));

        $this->reset();

        return $category;
    }
}
