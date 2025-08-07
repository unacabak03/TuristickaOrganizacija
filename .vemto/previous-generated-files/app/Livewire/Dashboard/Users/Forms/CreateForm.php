<?php

namespace App\Livewire\Dashboard\Users\Forms;

use Livewire\Form;
use App\Models\User;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Hash;

class CreateForm extends Form
{
    #[Rule('required|string')]
    public $name = '';

    #[Rule('required|string|unique:users,email')]
    public $email = '';

    #[Rule('required|string')]
    public $phone_number = '';

    #[Rule('required|string|min:6')]
    public $password = '';

    #[Rule('required')]
    public $role = '';

    public function save()
    {
        $this->validate();

        $this->password = Hash::make($this->password);

        $user = User::create($this->except([]));

        $this->reset();

        return $user;
    }
}
