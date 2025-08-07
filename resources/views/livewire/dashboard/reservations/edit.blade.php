<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 space-y-4">
    <x-ui.breadcrumbs>
        <x-ui.breadcrumbs.link href="/dashboard"
            >Dashboard</x-ui.breadcrumbs.link
        >
        <x-ui.breadcrumbs.separator />
        <x-ui.breadcrumbs.link
            href="{{ route('dashboard.reservations.index') }}"
            >{{ __('crud.reservations.collectionTitle')
            }}</x-ui.breadcrumbs.link
        >
        <x-ui.breadcrumbs.separator />
        <x-ui.breadcrumbs.link active
            >Edit {{ __('crud.reservations.itemTitle') }}</x-ui.breadcrumbs.link
        >
    </x-ui.breadcrumbs>

    <x-ui.toast on="saved"> Reservation saved successfully. </x-ui.toast>

    <div class="w-full text-gray-500 text-lg font-semibold py-4 uppercase">
        <h1>Edit {{ __('crud.reservations.itemTitle') }}</h1>
    </div>

    <div class="overflow-hidden border rounded-lg bg-white">
        <form class="w-full mb-0" wire:submit.prevent="save">
            <div class="p-6 space-y-3">
                <div class="w-full">
                    <x-ui.label for="user_id"
                        >{{ __('crud.reservations.inputs.user_id.label')
                        }}</x-ui.label
                    >
                    <x-ui.input.select
                        wire:model="form.user_id"
                        name="user_id"
                        id="user_id"
                        class="w-full"
                    >
                        <option value="">Select data</option>
                        @foreach ($users as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-ui.input.select>
                    <x-ui.input.error for="form.user_id" />
                </div>

                <div class="w-full">
                    <x-ui.label for="tour_id"
                        >{{ __('crud.reservations.inputs.tour_id.label')
                        }}</x-ui.label
                    >
                    <x-ui.input.select
                        wire:model="form.tour_id"
                        name="tour_id"
                        id="tour_id"
                        class="w-full"
                    >
                        <option value="">Select data</option>
                        @foreach ($tours as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-ui.input.select>
                    <x-ui.input.error for="form.tour_id" />
                </div>

                <div class="w-full">
                    <x-ui.label for="status"
                        >{{ __('crud.reservations.inputs.status.label')
                        }}</x-ui.label
                    >
                    <x-ui.input.select
                        wire:model="form.status"
                        class="w-full"
                        id="status"
                        name="status"
                    >
                        <option value="">Select</option>
                        <option value="placed">Placed</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="canceled">Canceled</option>
                    </x-ui.input.select>
                    <x-ui.input.error for="status" />
                </div>

                <div class="w-full">
                    <x-ui.label for="number_of_people"
                        >{{
                        __('crud.reservations.inputs.number_of_people.label')
                        }}</x-ui.label
                    >
                    <x-ui.input.number
                        class="w-full"
                        wire:model="form.number_of_people"
                        name="number_of_people"
                        id="number_of_people"
                        placeholder="{{ __('crud.reservations.inputs.number_of_people.placeholder') }}"
                        step="1"
                    />
                    <x-ui.input.error for="form.number_of_people" />
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
</div>
