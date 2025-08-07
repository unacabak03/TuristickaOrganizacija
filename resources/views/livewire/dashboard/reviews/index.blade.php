<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 space-y-4">
    <x-ui.breadcrumbs>
        <x-ui.breadcrumbs.link href="/dashboard"
            >Dashboard</x-ui.breadcrumbs.link
        >
        <x-ui.breadcrumbs.separator />
        <x-ui.breadcrumbs.link active
            >{{ __('crud.reviews.collectionTitle') }}</x-ui.breadcrumbs.link
        >
    </x-ui.breadcrumbs>

    <div class="flex justify-between align-top py-4">
        <x-ui.input
            wire:model.live="search"
            type="text"
            placeholder="Search {{ __('crud.reviews.collectionTitle') }}..."
        />

        @can('create', App\Models\Review::class)
        <a wire:navigate href="{{ route('dashboard.reviews.create') }}">
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
                wire:click="delete({{ $deletingReview }})"
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
                <x-ui.table.header for-crud wire:click="sortBy('user_id')"
                    >{{ __('crud.reviews.inputs.user_id.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.header for-crud wire:click="sortBy('tour_id')"
                    >{{ __('crud.reviews.inputs.tour_id.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.header for-crud wire:click="sortBy('rating')"
                    >{{ __('crud.reviews.inputs.rating.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.header for-crud wire:click="sortBy('comment')"
                    >{{ __('crud.reviews.inputs.comment.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.action-header>Actions</x-ui.table.action-header>
            </x-slot>

            <x-slot name="body">
                @forelse ($reviews as $review)
                <x-ui.table.row wire:loading.class.delay="opacity-75">
                    <x-ui.table.column for-crud
                        >{{ $review->user_id }}</x-ui.table.column
                    >
                    <x-ui.table.column for-crud
                        >{{ $review->tour_id }}</x-ui.table.column
                    >
                    <x-ui.table.column for-crud
                        >{{ $review->rating }}</x-ui.table.column
                    >
                    <x-ui.table.column for-crud
                        >{{ $review->comment }}</x-ui.table.column
                    >
                    <x-ui.table.action-column>
                        @can('update', $review)
                        <x-ui.action
                            wire:navigate
                            href="{{ route('dashboard.reviews.edit', $review) }}"
                            >Edit</x-ui.action
                        >
                        @endcan @can('delete', $review)
                        <x-ui.action.danger
                            wire:click="confirmDeletion({{ $review->id }})"
                            >Delete</x-ui.action.danger
                        >
                        @endcan
                    </x-ui.table.action-column>
                </x-ui.table.row>
                @empty
                <x-ui.table.row>
                    <x-ui.table.column colspan="5"
                        >No {{ __('crud.reviews.collectionTitle') }} found.</x-ui.table.column
                    >
                </x-ui.table.row>
                @endforelse
            </x-slot>
        </x-ui.table>

        <div class="mt-2">{{ $reviews->links() }}</div>
    </x-ui.container.table>
</div>
