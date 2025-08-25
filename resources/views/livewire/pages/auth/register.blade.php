<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.public')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $phone_number = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone_number' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'user';

        event(new Registered($user = User::create($validated)));
        Auth::login($user);

        $this->redirect(route('homepage', absolute: false), navigate: true);
    }
}; ?>

@push('head')
<style>
    .auth-wrap { max-width: 640px; margin: 48px auto; }
    .btn-orange { background:#ff7a00!important; color:#fff!important; font-weight:700; letter-spacing:.3px; transition:.2s; border:none; }
    .btn-orange:hover { background:#e86d00!important; color:#fff!important; }
    .w3-input { height:42px; }
    .field-label { font-weight:600; margin-bottom:6px; display:block; }
    .two-col { display:flex; gap:16px; }
    .two-col > div { flex:1; }
    .error { color:#b91c1c; font-size:.9rem; margin-top:4px; }
</style>
@endpush

<div class="auth-wrap">
    <div class="w3-card w3-white w3-round-large">
        <header class="w3-container w3-black">
            <h3 class="w3-margin">Registracija</h3>
        </header>

        <div class="w3-container w3-padding-16">
            <form wire:submit="register" class="w3-container">
                <div class="w3-section">
                    <label class="field-label" for="name">Ime i prezime</label>
                    <input wire:model="name" id="name" type="text" class="w3-input w3-border w3-round-small" required autofocus autocomplete="name">
                    @error('name') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="w3-section">
                    <label class="field-label" for="email">Email</label>
                    <input wire:model="email" id="email" type="email" class="w3-input w3-border w3-round-small" required autocomplete="username">
                    @error('email') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="w3-section">
                    <label class="field-label" for="phone_number">Telefon</label>
                    <input wire:model="phone_number" id="phone_number" type="text" class="w3-input w3-border w3-round-small" required>
                    @error('phone_number') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="two-col w3-section">
                    <div>
                        <label class="field-label" for="password">Lozinka</label>
                        <input wire:model="password" id="password" type="password" class="w3-input w3-border w3-round-small" required autocomplete="new-password">
                        @error('password') <div class="error">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="field-label" for="password_confirmation">Potvrda lozinke</label>
                        <input wire:model="password_confirmation" id="password_confirmation" type="password" class="w3-input w3-border w3-round-small" required autocomplete="new-password">
                        @error('password_confirmation') <div class="error">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="w3-section" style="display:flex; gap:12px; justify-content:space-between; align-items:center;">
                    <a href="{{ route('login') }}" wire:navigate class="w3-small w3-text-blue w3-hover-text-indigo">
                        Već imaš nalog? Prijavi se
                    </a>

                    <button type="submit" class="w3-button btn-orange w3-round-small">
                        Registruj se
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
