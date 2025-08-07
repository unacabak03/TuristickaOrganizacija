<div>
    <div class="flex justify-between align-top py-4">
        <x-ui.input
            wire:model.live="detailReservationsSearch"
            type="text"
            placeholder="Search {{ __('crud.reservations.collectionTitle') }}..."
        />

        @can('create', App\Models\Reservation::class)
        <a wire:click="newReservation()">
            <x-ui.button>New</x-ui.button>
        </a>
        @endcan
    </div>

    {{-- Modal --}}
    <x-ui.modal wire:model="showingModal">
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

                <div
                    class="flex justify-between mt-4 border-t border-gray-50 bg-gray-50 p-4"
                >
                    <div>
                        <!-- Other buttons here -->
                    </div>
                    <div>
                        <x-ui.button type="submit">Save</x-ui.button>
                    </div>
                </div>
            </form>
        </div>
    </x-ui.modal>

    {{-- Delete Modal --}}
    <x-ui.modal.confirm wire:model="confirmingReservationDeletion">
        <x-slot name="title"> {{ __('Delete') }} </x-slot>

        <x-slot name="content"> {{ __('Are you sure?') }} </x-slot>

        <x-slot name="footer">
            <x-ui.button
                wire:click="$toggle('confirmingReservationDeletion')"
                wire:loading.attr="disabled"
            >
                {{ __('Cancel') }}
            </x-ui.button>

            <x-ui.button.danger
                class="ml-3"
                wire:click="deleteReservation({{ $deletingReservation }})"
                wire:loading.attr="disabled"
            >
                {{ __('Delete') }}
            </x-ui.button.danger>
        </x-slot>
    </x-ui.modal.confirm>

    {{-- Index Table --}}
    <x-ui.container.table>
        <x-ui.table>
            <x-slot name="head">
                <x-ui.table.header for-detailCrud wire:click="sortBy('user_id')"
                    >{{ __('crud.reservations.inputs.user_id.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.header for-detailCrud wire:click="sortBy('status')"
                    >{{ __('crud.reservations.inputs.status.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.header
                    for-detailCrud
                    wire:click="sortBy('number_of_people')"
                    >{{ __('crud.reservations.inputs.number_of_people.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.action-header>Actions</x-ui.table.action-header>
            </x-slot>

            <x-slot name="body">
                @forelse ($detailReservations as $reservation)
                <x-ui.table.row wire:loading.class.delay="opacity-75">
                    <x-ui.table.column for-detailCrud
                        >{{ $reservation->user_id }}</x-ui.table.column
                    >
                    <x-ui.table.column for-detailCrud
                        >{{ $reservation->status }}</x-ui.table.column
                    >
                    <x-ui.table.column for-detailCrud
                        >{{ $reservation->number_of_people }}</x-ui.table.column
                    >
                    <x-ui.table.action-column>
                        @can('update', $reservation)
                        <x-ui.action
                            wire:click="editReservation({{ $reservation->id }})"
                            >Edit</x-ui.action
                        >
                        @endcan @can('delete', $reservation)
                        <x-ui.action.danger
                            wire:click="confirmReservationDeletion({{ $reservation->id }})"
                            >Delete</x-ui.action.danger
                        >
                        @endcan
                    </x-ui.table.action-column>
                </x-ui.table.row>
                @empty
                <x-ui.table.row>
                    <x-ui.table.column colspan="4"
                        >No {{ __('crud.reservations.collectionTitle') }} found.</x-ui.table.column
                    >
                </x-ui.table.row>
                @endforelse
            </x-slot>
        </x-ui.table>

        <div class="mt-2">{{ $detailReservations->links() }}</div>
    </x-ui.container.table>
</div>
