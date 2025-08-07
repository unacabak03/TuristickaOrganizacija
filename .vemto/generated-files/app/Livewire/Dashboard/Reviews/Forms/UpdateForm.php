<?php

namespace App\Livewire\Dashboard\Reviews\Forms;

use Livewire\Form;
use App\Models\Review;
use Illuminate\Validation\Rule;

class UpdateForm extends Form
{
    public ?Review $review;

    public $user_id = '';

    public $tour_id = '';

    public $rating = '';

    public $comment = '';

    public function rules(): array
    {
        return [
            'user_id' => ['required'],
            'tour_id' => ['required'],
            'rating' => ['required'],
            'comment' => ['required', 'string'],
        ];
    }

    public function setReview(Review $review)
    {
        $this->review = $review;

        $this->user_id = $review->user_id;
        $this->tour_id = $review->tour_id;
        $this->rating = $review->rating;
        $this->comment = $review->comment;
    }

    public function save()
    {
        $this->validate();

        $this->review->update($this->except(['review', 'user_id', 'tour_id']));
    }
}
