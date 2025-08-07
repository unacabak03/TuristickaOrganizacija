<?php

namespace App\Livewire\Dashboard\Reviews\Forms;

use Livewire\Form;
use App\Models\Review;
use Livewire\Attributes\Rule;

class CreateForm extends Form
{
    #[Rule('required')]
    public $user_id = '';

    #[Rule('required')]
    public $tour_id = '';

    #[Rule('required')]
    public $rating = '';

    #[Rule('required|string')]
    public $comment = '';

    public function save()
    {
        $this->validate();

        $review = Review::create($this->except([]));

        $this->reset();

        return $review;
    }
}
