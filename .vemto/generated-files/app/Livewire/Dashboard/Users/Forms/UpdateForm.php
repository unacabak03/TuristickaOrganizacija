<?php

namespace App\Livewire\Dashboard\Users\Forms;

use Livewire\Form;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UpdateForm extends Form
{
    public ?User $user;

    public $name = '';

    public $email = '';

    public $phone_number = '';

    public $password = '';

    public $role = '';

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => [
                'required',
                'string',
                Rule::unique('users', 'email')->ignore($this->user),
            ],
            'phone_number' => ['required', 'string'],
            'password' => ['nullable', 'string', 'min:6'],
            'role' => ['required'],
        ];
    }

    public function setUser(User $user)
    {
        $this->user = $user;

        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone_number = $user->phone_number;
        $this->role = $user->role;
    }

    public function save()
    {
        $this->validate();

        $this->password = Hash::make($this->password);

        $this->user->update($this->except(['user']));
    }
}
