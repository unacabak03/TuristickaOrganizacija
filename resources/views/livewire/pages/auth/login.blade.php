<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.public')] class extends Component
{
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();
        $this->form->authenticate();
        Session::regenerate();

        $user = auth()->user();
        $default = in_array($user->role, ['admin','manager'], true)
            ? route('dashboard', absolute: false)
            : route('homepage', absolute: false);

        $this->redirectIntended(default: $default, navigate: true);
    }
}; ?>

@push('head')
<style>
    .auth-wrap { max-width: 560px; margin: 48px auto; }
    .btn-orange { background:#ff7a00!important; color:#fff!important; font-weight:700; letter-spacing:.3px; transition:.2s; border:none; }
    .btn-orange:hover { background:#e86d00!important; color:#fff!important; }
    .w3-input { height:42px; }
    .field-label { font-weight:600; margin-bottom:6px; display:block; }
    .error { color:#b91c1c; font-size:.9rem; margin-top:4px; }
</style>
@endpush

<div class="auth-wrap">
    <div class="w3-card w3-white w3-round-large">
        <header class="w3-container w3-black">
            <h3 class="w3-margin">Prijava</h3>
        </header>

        <div class="w3-container w3-padding-16">
            @if (session('status'))
                <div class="w3-panel w3-pale-green w3-leftbar w3-border-green w3-round">
                    {{ session('status') }}
                </div>
            @endif

            <form wire:submit="login" class="w3-container">
                <div class="w3-section">
                    <label class="field-label" for="email">Email</label>
                    <input wire:model="form.email" id="email" type="email" class="w3-input w3-border w3-round-small" required autofocus autocomplete="username">
                    @error('form.email') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="w3-section">
                    <label class="field-label" for="password">Lozinka</label>
                    <input wire:model="form.password" id="password" type="password" class="w3-input w3-border w3-round-small" required autocomplete="current-password">
                    @error('form.password') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="w3-section">
                    <label class="w3-small">
                        <input wire:model="form.remember" id="remember" type="checkbox" class="w3-check">
                        Zapamti me
                    </label>
                </div>

                <div class="w3-section" style="display:flex; gap:12px; justify-content:space-between; align-items:center;">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" wire:navigate class="w3-small w3-text-blue w3-hover-text-indigo">
                            Zaboravljena lozinka?
                        </a>
                    @endif

                    <button type="submit" class="w3-button btn-orange w3-round-small">
                        Prijavi se
                    </button>
                </div>

                <div class="w3-section" style="text-align:center">
                    <span class="w3-small">Nemaš nalog?</span>
                    <a href="{{ route('register') }}" wire:navigate class="w3-small w3-text-blue w3-hover-text-indigo">
                        Registruj se
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
