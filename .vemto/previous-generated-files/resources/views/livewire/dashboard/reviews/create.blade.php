<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 space-y-4">
    <x-ui.breadcrumbs>
        <x-ui.breadcrumbs.link href="/dashboard"
            >Dashboard</x-ui.breadcrumbs.link
        >
        <x-ui.breadcrumbs.separator />
        <x-ui.breadcrumbs.link href="{{ route('dashboard.reviews.index') }}"
            >{{ __('crud.reviews.collectionTitle') }}</x-ui.breadcrumbs.link
        >
        <x-ui.breadcrumbs.separator />
        <x-ui.breadcrumbs.link active
            >Create {{ __('crud.reviews.itemTitle') }}</x-ui.breadcrumbs.link
        >
    </x-ui.breadcrumbs>

    <div class="w-full text-gray-500 text-lg font-semibold py-4 uppercase">
        <h1>Create {{ __('crud.reviews.itemTitle') }}</h1>
    </div>

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
                    <x-ui.label for="tour_id"
                        >{{ __('crud.reviews.inputs.tour_id.label')
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
