<div>
    <div class="flex justify-between align-top py-4">
        <x-ui.input
            wire:model.live="detailReviewsSearch"
            type="text"
            placeholder="Search {{ __('crud.reviews.collectionTitle') }}..."
        />

        @can('create', App\Models\Review::class)
        <a wire:click="newReview()">
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
                            >{{ __('crud.reviews.inputs.user_id.label')
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
                        <x-ui.label for="rating"
                            >{{ __('crud.reviews.inputs.rating.label')
                            }}</x-ui.label
                        >
                        <x-ui.input.number
                            class="w-full"
                            wire:model="form.rating"
                            name="rating"
                            id="rating"
                            placeholder="{{ __('crud.reviews.inputs.rating.placeholder') }}"
                            step="1"
                        />
                        <x-ui.input.error for="form.rating" />
                    </div>

                    <div class="w-full">
                        <x-ui.label for="comment"
                            >{{ __('crud.reviews.inputs.comment.label')
                            }}</x-ui.label
                        >
                        <x-ui.input.text
                            class="w-full"
                            wire:model="form.comment"
                            name="comment"
                            id="comment"
                            placeholder="{{ __('crud.reviews.inputs.comment.placeholder') }}"
                        />
                        <x-ui.input.error for="form.comment" />
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
    <x-ui.modal.confirm wire:model="confirmingReviewDeletion">
        <x-slot name="title"> {{ __('Delete') }} </x-slot>

        <x-slot name="content"> {{ __('Are you sure?') }} </x-slot>

        <x-slot name="footer">
            <x-ui.button
                wire:click="$toggle('confirmingReviewDeletion')"
                wire:loading.attr="disabled"
            >
                {{ __('Cancel') }}
            </x-ui.button>

            <x-ui.button.danger
                class="ml-3"
                wire:click="deleteReview({{ $deletingReview }})"
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
                    >{{ __('crud.reviews.inputs.user_id.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.header for-detailCrud wire:click="sortBy('rating')"
                    >{{ __('crud.reviews.inputs.rating.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.header for-detailCrud wire:click="sortBy('comment')"
                    >{{ __('crud.reviews.inputs.comment.label')
                    }}</x-ui.table.header
                >
                <x-ui.table.action-header>Actions</x-ui.table.action-header>
            </x-slot>

            <x-slot name="body">
                @forelse ($detailReviews as $review)
                <x-ui.table.row wire:loading.class.delay="opacity-75">
                    <x-ui.table.column for-detailCrud
                        >{{ $review->user_id }}</x-ui.table.column
                    >
                    <x-ui.table.column for-detailCrud
                        >{{ $review->rating }}</x-ui.table.column
                    >
                    <x-ui.table.column for-detailCrud
                        >{{ $review->comment }}</x-ui.table.column
                    >
                    <x-ui.table.action-column>
                        @can('update', $review)
                        <x-ui.action wire:click="editReview({{ $review->id }})"
                            >Edit</x-ui.action
                        >
                        @endcan @can('delete', $review)
                        <x-ui.action.danger
                            wire:click="confirmReviewDeletion({{ $review->id }})"
                            >Delete</x-ui.action.danger
                        >
                        @endcan
                    </x-ui.table.action-column>
                </x-ui.table.row>
                @empty
                <x-ui.table.row>
                    <x-ui.table.column colspan="4"
                        >No {{ __('crud.reviews.collectionTitle') }} found.</x-ui.table.column
                    >
                </x-ui.table.row>
                @endforelse
            </x-slot>
        </x-ui.table>

        <div class="mt-2">{{ $detailReviews->links() }}</div>
    </x-ui.container.table>
</div>
