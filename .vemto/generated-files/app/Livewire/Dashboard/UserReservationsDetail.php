<?php

namespace App\Livewire\Dashboard;

use Livewire\Form;
use App\Models\User;
use App\Models\Tour;
use Livewire\Component;
use App\Models\Reservation;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use App\Livewire\Dashboard\Reservations\Forms\CreateDetailForm;
use App\Livewire\Dashboard\Reservations\Forms\UpdateDetailForm;

class UserReservationsDetail extends Component
{
    use WithFileUploads, WithPagination;

    public CreateDetailForm|UpdateDetailForm $form;

    public ?Reservation $reservation;
    public User $user;

    public Collection $tours;

    public $showingModal = false;

    public $detailReservationsSearch = '';
    public $detailReservationsSortField = 'updated_at';
    public $detailReservationsSortDirection = 'desc';

    public $queryString = [
        'detailReservationsSearch',
        'detailReservationsSortField',
        'detailReservationsSortDirection',
    ];

    public $confirmingReservationDeletion = false;
    public string $deletingReservation;

    public function mount()
    {
        $this->form = new CreateDetailForm($this, 'form');

        $this->tours = Tour::pluck('title', 'id');
    }

    public function newReservation()
    {
        $this->form = new CreateDetailForm($this, 'form');
        $this->reservation = null;

        $this->showModal();
    }

    public function editReservation(Reservation $reservation)
    {
        $this->form = new UpdateDetailForm($this, 'form');
        $this->form->setReservation($reservation);
        $this->reservation = $reservation;

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

    public function confirmReservationDeletion(string $id)
    {
        $this->deletingReservation = $id;

        $this->confirmingReservationDeletion = true;
    }

    public function deleteReservation(Reservation $reservation)
    {
        $this->authorize('delete', $reservation);

        $reservation->delete();

        $this->confirmingReservationDeletion = false;
    }

    public function save()
    {
        if (empty($this->reservation)) {
            $this->authorize('create', Reservation::class);
        } else {
            $this->authorize('update', $this->reservation);
        }

        $this->form->user_id = $this->user->id;
        $this->form->save();

        $this->closeModal();
    }

    public function sortBy($field)
    {
        if ($this->detailReservationsSortField === $field) {
            $this->detailReservationsSortDirection =
                $this->detailReservationsSortDirection === 'asc'
                    ? 'desc'
                    : 'asc';
        } else {
            $this->detailReservationsSortDirection = 'asc';
        }

        $this->detailReservationsSortField = $field;
    }

    public function getRowsProperty()
    {
        return $this->rowsQuery->paginate(5);
    }

    public function getRowsQueryProperty()
    {
        return $this->user
            ->reservations()
            ->orderBy(
                $this->detailReservationsSortField,
                $this->detailReservationsSortDirection
            )
            ->where(
                'created_at',
                'like',
                "%{$this->detailReservationsSearch}%"
            );
    }

    public function render()
    {
        return view('livewire.dashboard.users.reservations-detail', [
            'detailReservations' => $this->rows,
        ]);
    }
}
