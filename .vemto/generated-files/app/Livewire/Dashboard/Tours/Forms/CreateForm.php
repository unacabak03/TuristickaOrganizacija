<?php

namespace App\Livewire\Dashboard\Tours\Forms;

use Livewire\Form;
use App\Models\Tour;
use Livewire\Attributes\Rule;

class CreateForm extends Form
{
    #[Rule('required|string')]
    public $title = '';

    #[Rule('required|string')]
    public $description = '';

    #[Rule('required|string')]
    public $location = '';

    #[Rule('required')]
    public $price = '';

    #[Rule('required|date')]
    public $start_date = '';

    #[Rule('required|date')]
    public $end_date = '';

    #[Rule('nullable')]
    public $max_participants = '';

    public function save()
    {
        $this->validate();

        $tour = Tour::create($this->except([]));

        $this->reset();

        return $tour;
    }
}
