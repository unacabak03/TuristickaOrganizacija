<?php

namespace App\Livewire\Dashboard;

use App\Models\Tour;
use Livewire\Component;
use Livewire\WithPagination;

class TourIndex extends Component
{
    use WithPagination;

    public $search;
    public $sortField = 'updated_at';
    public $sortDirection = 'desc';

    public $queryString = ['search', 'sortField', 'sortDirection'];

    public $confirmingDeletion = false;
    public $deletingTour;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmDeletion(string $id)
    {
        $this->deletingTour = $id;

        $this->confirmingDeletion = true;
    }

    public function delete(Tour $tour)
    {
        $tour->delete();

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
        return Tour::query()
            ->orderBy($this->sortField, $this->sortDirection)
            ->where('title', 'like', "%{$this->search}%");
    }

    public function render()
    {
        return view('livewire.dashboard.tours.index', [
            'tours' => $this->rows,
        ]);
    }
}
