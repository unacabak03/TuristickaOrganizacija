<?php

namespace App\Livewire\Dashboard;

use App\Models\User;
use App\Models\Tour;
use App\Models\Review;
use Livewire\Component;
use Illuminate\Support\Collection;
use App\Livewire\Dashboard\Reviews\Forms\UpdateForm;

class ReviewEdit extends Component
{
    public ?Review $review = null;

    public UpdateForm $form;
    public Collection $users;
    public Collection $tours;

    public function mount(Review $review)
    {
        $this->authorize('view-any', Review::class);

        $this->review = $review;

        $this->form->setReview($review);
        $this->users = User::pluck('name', 'id');
        $this->tours = Tour::pluck('title', 'id');
    }

    public function save()
    {
        $this->authorize('update', $this->review);

        $this->validate();

        $this->form->save();

        $this->dispatch('saved');
    }

    public function render()
    {
        return view('livewire.dashboard.reviews.edit', []);
    }
}
