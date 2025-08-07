<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 space-y-4">
    <x-ui.breadcrumbs>
        <x-ui.breadcrumbs.link href="/dashboard"
            >Dashboard</x-ui.breadcrumbs.link
        >
        <x-ui.breadcrumbs.separator />
        <x-ui.breadcrumbs.link href="{{ route('dashboard.users.index') }}"
            >{{ __('crud.users.collectionTitle') }}</x-ui.breadcrumbs.link
        >
        <x-ui.breadcrumbs.separator />
        <x-ui.breadcrumbs.link active
            >Edit {{ __('crud.users.itemTitle') }}</x-ui.breadcrumbs.link
        >
    </x-ui.breadcrumbs>

    <x-ui.toast on="saved"> User saved successfully. </x-ui.toast>

    <div class="w-full text-gray-500 text-lg font-semibold py-4 uppercase">
        <h1>Edit {{ __('crud.users.itemTitle') }}</h1>
    </div>

    <div class="overflow-hidden border rounded-lg bg-white">
        <form class="w-full mb-0" wire:submit.prevent="save">
            <div class="p-6 space-y-3">
                <div class="w-full">
                    <x-ui.label for="name"
                        >{{ __('crud.users.inputs.name.label') }}</x-ui.label
                    >
                    <x-ui.input.text
                        class="w-full"
                        wire:model="form.name"
                        name="name"
                        id="name"
                        placeholder="{{ __('crud.users.inputs.name.placeholder') }}"
                    />
                    <x-ui.input.error for="form.name" />
                </div>

                <div class="w-full">
                    <x-ui.label for="email"
                        >{{ __('crud.users.inputs.email.label') }}</x-ui.label
                    >
                    <x-ui.input.email
                        class="w-full"
                        wire:model="form.email"
                        name="email"
                        id="email"
                        placeholder="{{ __('crud.users.inputs.email.placeholder') }}"
                    />
                    <x-ui.input.error for="form.email" />
                </div>

                <div class="w-full">
                    <x-ui.label for="phone_number"
                        >{{ __('crud.users.inputs.phone_number.label')
                        }}</x-ui.label
                    >
                    <x-ui.input.text
                        class="w-full"
                        wire:model="form.phone_number"
                        name="phone_number"
                        id="phone_number"
                        placeholder="{{ __('crud.users.inputs.phone_number.placeholder') }}"
                    />
                    <x-ui.input.error for="form.phone_number" />
                </div>

                <div class="w-full">
                    <x-ui.label for="password"
                        >{{ __('crud.users.inputs.password.label')
                        }}</x-ui.label
                    >
                    <x-ui.input.password
                        class="w-full"
                        wire:model="form.password"
                        name="password"
                        id="password"
                        placeholder="{{ __('crud.users.inputs.password.placeholder') }}"
                    />
                    <x-ui.input.error for="form.password" />
                </div>

                <div class="w-full">
                    <x-ui.label for="role"
                        >{{ __('crud.users.inputs.role.label') }}</x-ui.label
                    >
                    <x-ui.input.select
                        wire:model="form.role"
                        class="w-full"
                        id="role"
                        name="role"
                    >
                        <option value="">Select</option>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                        <option value="manager">Manager</option>
                    </x-ui.input.select>
                    <x-ui.input.error for="role" />
                </div>
            </div>

            <div class="flex justify-between mt-4 border-t border-gray-50 p-4">
                <div>
                    <!-- Other buttons here -->
                </div>
                <div>
                    <x-ui.button type="submit">Save</x-ui.button>
                </div>
            </div>
        </form>
    </div>

    @can('view-any', App\Models\Reservation::class)
    <div class="overflow-hidden border rounded-lg bg-white">
        <div class="w-full mb-0">
            <div class="p-6 space-y-3">
                <div
                    class="w-full text-gray-500 text-lg font-semibold py-4 uppercase"
                >
                    <h2>{{ __('crud.reservations.collectionTitle') }}</h2>
                </div>

                <livewire:dashboard.user-reservations-detail :user="$user" />
            </div>
        </div>
    </div>
    @endcan @can('view-any', App\Models\Review::class)
    <div class="overflow-hidden border rounded-lg bg-white">
        <div class="w-full mb-0">
            <div class="p-6 space-y-3">
                <div
                    class="w-full text-gray-500 text-lg font-semibold py-4 uppercase"
                >
                    <h2>{{ __('crud.reviews.collectionTitle') }}</h2>
                </div>

                <livewire:dashboard.user-reviews-detail :user="$user" />
            </div>
        </div>
    </div>
    @endcan
</div>
