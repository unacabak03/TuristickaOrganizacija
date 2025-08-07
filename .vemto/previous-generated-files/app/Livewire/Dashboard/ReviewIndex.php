<?php

namespace App\Livewire\Dashboard;

use App\Models\Review;
use Livewire\Component;
use Livewire\WithPagination;

class ReviewIndex extends Component
{
    use WithPagination;

    public $search;
    public $sortField = 'updated_at';
    public $sortDirection = 'desc';

    public $queryString = ['search', 'sortField', 'sortDirection'];

    public $confirmingDeletion = false;
    public $deletingReview;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmDeletion(string $id)
    {
        $this->deletingReview = $id;

        $this->confirmingDeletion = true;
    }

    public function delete(Review $review)
    {
        $review->delete();

        $this->confirmingDeletion = false;
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection =
                $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    public function getRowsProperty()
    {
        return $this->rowsQuery->paginate(5);
    }

    public function getRowsQueryProperty()
    {
        return Review::query()
            ->orderBy($this->sortField, $this->sortDirection)
            ->where('comment', 'like', "%{$this->search}%");
    }

    public function render()
    {
        return view('livewire.dashboard.reviews.index', [
            'reviews' => $this->rows,
        ]);
    }
}
