<?php

namespace App\Livewire\Dashboard\Reviews\Forms;

use Livewire\Form;
use App\Models\Review;
use Livewire\Attributes\Rule;

class CreateDetailForm extends Form
{
    public $tour_id = null;

    #[Rule('required')]
    public $user_id = '';

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
