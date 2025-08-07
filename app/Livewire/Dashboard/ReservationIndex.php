<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Reservation;
use Livewire\WithPagination;

class ReservationIndex extends Component
{
    use WithPagination;

    public $search;
    public $sortField = 'updated_at';
    public $sortDirection = 'desc';

    public $queryString = ['search', 'sortField', 'sortDirection'];

    public $confirmingDeletion = false;
    public $deletingReservation;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmDeletion(string $id)
    {
        $this->deletingReservation = $id;

        $this->confirmingDeletion = true;
    }

    public function delete(Reservation $reservation)
    {
        $reservation->delete();

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
        return Reservation::query()
            ->orderBy($this->sortField, $this->sortDirection)
            ->where('created_at', 'like', "%{$this->search}%");
    }

    public function render()
    {
        return view('livewire.dashboard.reservations.index', [
            'reservations' => $this->rows,
        ]);
    }
}
