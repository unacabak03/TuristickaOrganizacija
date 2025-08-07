<?php

namespace App\Livewire\Dashboard\Tours\Forms;

use Livewire\Form;
use App\Models\Tour;
use Illuminate\Validation\Rule;

class UpdateForm extends Form
{
    public ?Tour $tour;

    public $title = '';

    public $description = '';

    public $location = '';

    public $price = '';

    public $start_date = '';

    public $end_date = '';

    public $max_participants = '';

    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'location' => ['required', 'string'],
            'price' => ['required'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'max_participants' => ['nullable'],
        ];
    }

    public function setTour(Tour $tour)
    {
        $this->tour = $tour;

        $this->title = $tour->title;
        $this->description = $tour->description;
        $this->location = $tour->location;
        $this->price = $tour->price;
        $this->start_date = $tour->start_date;
        $this->end_date = $tour->end_date;
        $this->max_participants = $tour->max_participants;
    }

    public function save()
    {
        $this->validate();

        $this->tour->update($this->except(['tour']));
    }
}
