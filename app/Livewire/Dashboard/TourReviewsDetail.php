<?php

namespace App\Livewire\Dashboard;

use Livewire\Form;
use App\Models\Tour;
use App\Models\User;
use App\Models\Review;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use App\Livewire\Dashboard\Reviews\Forms\CreateDetailForm;
use App\Livewire\Dashboard\Reviews\Forms\UpdateDetailForm;

class TourReviewsDetail extends Component
{
    use WithFileUploads, WithPagination;

    public CreateDetailForm|UpdateDetailForm $form;

    public ?Review $review;
    public Tour $tour;

    public Collection $users;

    public $showingModal = false;

    public $detailReviewsSearch = '';
    public $detailReviewsSortField = 'updated_at';
    public $detailReviewsSortDirection = 'desc';

    public $queryString = [
        'detailReviewsSearch',
        'detailReviewsSortField',
        'detailReviewsSortDirection',
    ];

    public $confirmingReviewDeletion = false;
    public string $deletingReview;

    public function mount()
    {
        $this->form = new CreateDetailForm($this, 'form');

        $this->users = User::pluck('name', 'id');
    }

    public function newReview()
    {
        $this->form = new CreateDetailForm($this, 'form');
        $this->review = null;

        $this->showModal();
    }

    public function editReview(Review $review)
    {
        $this->form = new UpdateDetailForm($this, 'form');
        $this->form->setReview($review);
        $this->review = $review;

        $this->showModal();
    }

    public function showModal()
    {
        $this->showingModal = true;
    }

    public function closeModal()
    {
        $this->showingModal = false;
    }

    public function confirmReviewDeletion(string $id)
    {
        $this->deletingReview = $id;

        $this->confirmingReviewDeletion = true;
    }

    public function deleteReview(Review $review)
    {
        $this->authorize('delete', $review);

        $review->delete();

        $this->confirmingReviewDeletion = false;
    }

    public function save()
    {
        if (empty($this->review)) {
            $this->authorize('create', Review::class);
        } else {
            $this->authorize('update', $this->review);
        }

        $this->form->tour_id = $this->tour->id;
        $this->form->save();

        $this->closeModal();
    }

    public function sortBy($field)
    {
        if ($this->detailReviewsSortField === $field) {
            $this->detailReviewsSortDirection =
                $this->detailReviewsSortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->detailReviewsSortDirection = 'asc';
        }

        $this->detailReviewsSortField = $field;
    }

    public function getRowsProperty()
    {
        return $this->rowsQuery->paginate(5);
    }

    public function getRowsQueryProperty()
    {
        return $this->tour
            ->reviews()
            ->orderBy(
                $this->detailReviewsSortField,
                $this->detailReviewsSortDirection
            )
            ->where('comment', 'like', "%{$this->detailReviewsSearch}%");
    }

    public function render()
    {
        return view('livewire.dashboard.tours.reviews-detail', [
            'detailReviews' => $this->rows,
        ]);
    }
}
