<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 space-y-4">
    <x-ui.breadcrumbs>
        <x-ui.breadcrumbs.link href="/dashboard"
            >Dashboard</x-ui.breadcrumbs.link
        >
        <x-ui.breadcrumbs.separator />
        <x-ui.breadcrumbs.link href="{{ route('dashboard.tours.index') }}"
            >{{ __('crud.tours.collectionTitle') }}</x-ui.breadcrumbs.link
        >
        <x-ui.breadcrumbs.separator />
        <x-ui.breadcrumbs.link active
            >Create {{ __('crud.tours.itemTitle') }}</x-ui.breadcrumbs.link
        >
    </x-ui.breadcrumbs>

    <div class="w-full text-gray-500 text-lg font-semibold py-4 uppercase">
        <h1>Create {{ __('crud.tours.itemTitle') }}</h1>
    </div>

    <div class="overflow-hidden border rounded-lg bg-white">
        <form class="w-full mb-0" wire:submit.prevent="save">
            <div class="p-6 space-y-3">
                <div class="w-full">
                    <x-ui.label for="title"
                        >{{ __('crud.tours.inputs.title.label') }}</x-ui.label
                    >
                    <x-ui.input.text
                        class="w-full"
                        wire:model="form.title"
                        name="title"
                        id="title"
                        placeholder="{{ __('crud.tours.inputs.title.placeholder') }}"
                    />
                    <x-ui.input.error for="form.title" />
                </div>

                <div class="w-full">
                    <x-ui.label for="description"
                        >{{ __('crud.tours.inputs.description.label')
                        }}</x-ui.label
                    >
                    <x-ui.input.textarea
                        class="w-full"
                        wire:model="form.description"
                        rows="6"
                        name="description"
                        id="description"
                        placeholder="{{ __('crud.tours.inputs.description.placeholder') }}"
                    />
                    <x-ui.input.error for="form.description" />
                </div>

                <div class="w-full">
                    <x-ui.label for="location"
                        >{{ __('crud.tours.inputs.location.label')
                        }}</x-ui.label
                    >
                    <x-ui.input.text
                        class="w-full"
                        wire:model="form.location"
                        name="location"
                        id="location"
                        placeholder="{{ __('crud.tours.inputs.location.placeholder') }}"
                    />
                    <x-ui.input.error for="form.location" />
                </div>

                <div class="w-full">
                    <x-ui.label for="price"
                        >{{ __('crud.tours.inputs.price.label') }}</x-ui.label
                    >
                    <x-ui.input.number
                        class="w-full"
                        wire:model="form.price"
                        name="price"
                        id="price"
                        placeholder="{{ __('crud.tours.inputs.price.placeholder') }}"
                        step="1"
                    />
                    <x-ui.input.error for="form.price" />
                </div>

                <div class="w-full">
                    <x-ui.label for="start_date"
                        >{{ __('crud.tours.inputs.start_date.label')
                        }}</x-ui.label
                    >
                    <x-ui.input.date
                        class="w-full"
                        wire:model="form.start_date"
                        name="start_date"
                        id="start_date"
                    />
                    <x-ui.input.error for="form.start_date" />
                </div>

                <div class="w-full">
                    <x-ui.label for="end_date"
                        >{{ __('crud.tours.inputs.end_date.label')
                        }}</x-ui.label
                    >
                    <x-ui.input.date
                        class="w-full"
                        wire:model="form.end_date"
                        name="end_date"
                        id="end_date"
                    />
                    <x-ui.input.error for="form.end_date" />
                </div>

                <div class="w-full">
                    <x-ui.label for="max_participants"
                        >{{ __('crud.tours.inputs.max_participants.label')
                        }}</x-ui.label
                    >
                    <x-ui.input.number
                        class="w-full"
                        wire:model="form.max_participants"
                        name="max_participants"
                        id="max_participants"
                        placeholder="{{ __('crud.tours.inputs.max_participants.placeholder') }}"
                        step="1"
                    />
                    <x-ui.input.error for="form.max_participants" />
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
