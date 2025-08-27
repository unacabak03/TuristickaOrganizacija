<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

@php
    $role = auth()->user()->role ?? 'user';

    $allMenu = [
        'users'        => ['label' => 'Users',        'name' => 'dashboard.users.index'],
        'tours'        => ['label' => 'Tours',        'name' => 'dashboard.tours.index'],
        'reservations' => ['label' => 'Reservations', 'name' => 'dashboard.reservations.index'],
        'reviews'      => ['label' => 'Reviews',      'name' => 'dashboard.reviews.index'],
        'categories'   => ['label' => 'Categories',   'name' => 'dashboard.categories.index'],
    ];

    $menuByRole = [
        'admin'   => ['users','tours','reservations','reviews','categories'],
        'manager' => ['reservations'],
        'user'    => [],
    ];

    $menu = collect($menuByRole[$role] ?? [])
        ->map(fn($key) => $allMenu[$key] ?? null)
        ->filter(function ($item) {
            return $item && Route::has($item['name']);
        })
        ->values()
        ->all();

    $activePattern = function (string $name): string {
        return preg_replace('/\.index$/', '.*', $name) ?: $name;
    };
@endphp

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" wire:navigate>
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <div class="hidden sm:flex sm:items-center sm:ms-10 gap-6">
                    @if (Route::has('dashboard'))
                        <x-nav-link :href="route('dashboard')"
                                    :active="request()->routeIs('dashboard')"
                                    wire:navigate>
                            {{ __('Dashboard') }}
                        </x-nav-link>
                    @endif

                    @foreach ($menu as $item)
                        @php $pattern = $activePattern($item['name']); @endphp
                        <x-nav-link :href="route($item['name'])"
                                    :active="request()->routeIs($pattern)"
                                    wire:navigate>
                            {{ __($item['label']) }}
                        </x-nav-link>
                    @endforeach
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}"
                                    x-text="name"
                                    x-on:profile-updated.window="name = $event.detail.name"></div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @if (Route::has('profile'))
                            <x-dropdown-link :href="route('profile')" wire:navigate>
                                {{ __('Profile') }}
                            </x-dropdown-link>
                        @endif

                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out"
                        aria-label="Open main menu">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }"
                                class="inline-flex"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }"
                                class="hidden"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @if (Route::has('dashboard'))
                <x-responsive-nav-link :href="route('dashboard')"
                                    :active="request()->routeIs('dashboard')"
                                    wire:navigate>
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            @endif

            @foreach ($menu as $item)
                @php $pattern = $activePattern($item['name']); @endphp
                <x-responsive-nav-link :href="route($item['name'])"
                                    :active="request()->routeIs($pattern)"
                                    wire:navigate>
                    {{ __($item['label']) }}
                </x-responsive-nav-link>
            @endforeach
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800"
                        x-data="{{ json_encode(['name' => auth()->user()->name]) }}"
                        x-text="name"
                        x-on:profile-updated.window="name = $event.detail.name"></div>
                <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                @if (Route::has('profile'))
                    <x-responsive-nav-link :href="route('profile')" wire:navigate>
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                @endif

                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link>
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </button>
            </div>
        </div>
    </div>
</nav>
