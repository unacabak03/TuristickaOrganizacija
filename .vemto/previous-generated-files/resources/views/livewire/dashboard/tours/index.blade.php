<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 space-y-4">
    <x-ui.breadcrumbs>
        <x-ui.breadcrumbs.link href="/dashboard"
            >Dashboard</x-ui.breadcrumbs.link
        >
        <x-ui.breadcrumbs.separator />
        <x-ui.breadcrumbs.link active
            >{{ __('crud.tours.collectionTitle') }}</x-ui.breadcrumbs.link
        >
    </x-ui.breadcrumbs>

    <div class="flex justify-between align-top py-4">
        <x-ui.input
            wire:model.live="search"
            type="text"
            placeholder="Search {{ __('crud.tours.collectionTitle') }}..."
        />

        @can('create', App\Models\Tour::class)
        <a wire:navigate href="{{ route('dashboard.tours.create') }}">
            <x-ui.button>New</x-ui.button>
        </a>
        @endcan
    </div>

    {{-- Delete Modal --}}
    <x-ui.modal.confirm wire:model="confirmingDeletion">
        <x-slot name="title"> {{ __('Delete') }} </x-slot>

        <x-slot name="content"> {{ __('Are you sure?') }} </x-slot>

        <x-slot name="footer">
            <x-ui.button
                wire:click="$toggle('confirmingDeletion')"
                wire:loading.attr="disabled"
            >
                {{ __('Cancel') }}
            </x-ui.button>

            <x-ui.button.danger
                class="ml-3"
                wire:click="delete({{ $deletingTour }})"
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
                <x-ui.table.header for-crud wire:click="sortBy('title')"
                    >{{ __('crud.tours.inputs.title.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.header for-crud wire:click="sortBy('description')"
                    >{{ __('crud.tours.inputs.description.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.header for-crud wire:click="sortBy('location')"
                    >{{ __('crud.tours.inputs.location.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.header for-crud wire:click="sortBy('price')"
                    >{{ __('crud.tours.inputs.price.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.header for-crud wire:click="sortBy('start_date')"
                    >{{ __('crud.tours.inputs.start_date.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.header for-crud wire:click="sortBy('end_date')"
                    >{{ __('crud.tours.inputs.end_date.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.header
                    for-crud
                    wire:click="sortBy('max_participants')"
                    >{{ __('crud.tours.inputs.max_participants.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.action-header>Actions</x-ui.table.action-header>
            </x-slot>

            <x-slot name="body">
                @forelse ($tours as $tour)
                <x-ui.table.row wire:loading.class.delay="opacity-75">
                    <x-ui.table.column for-crud
                        >{{ $tour->title }}</x-ui.table.column
                    >
                    <x-ui.table.column for-crud
                        >{{ $tour->description }}</x-ui.table.column
                    >
                    <x-ui.table.column for-crud
                        >{{ $tour->location }}</x-ui.table.column
                    >
                    <x-ui.table.column for-crud
                        >{{ $tour->price }}</x-ui.table.column
                    >
                    <x-ui.table.column for-crud
                        >{{ $tour->start_date }}</x-ui.table.column
                    >
                    <x-ui.table.column for-crud
                        >{{ $tour->end_date }}</x-ui.table.column
                    >
                    <x-ui.table.column for-crud
                        >{{ $tour->max_participants }}</x-ui.table.column
                    >
                    <x-ui.table.action-column>
                        @can('update', $tour)
                        <x-ui.action
                            wire:navigate
                            href="{{ route('dashboard.tours.edit', $tour) }}"
                            >Edit</x-ui.action
                        >
                        @endcan @can('delete', $tour)
                        <x-ui.action.danger
                            wire:click="confirmDeletion({{ $tour->id }})"
                            >Delete</x-ui.action.danger
                        >
                        @endcan
                    </x-ui.table.action-column>
                </x-ui.table.row>
                @empty
                <x-ui.table.row>
                    <x-ui.table.column colspan="8"
                        >No {{ __('crud.tours.collectionTitle') }} found.</x-ui.table.column
                    >
                </x-ui.table.row>
                @endforelse
            </x-slot>
        </x-ui.table>

        <div class="mt-2">{{ $tours->links() }}</div>
    </x-ui.container.table>
</div>
