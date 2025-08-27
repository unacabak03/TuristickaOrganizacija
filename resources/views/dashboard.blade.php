<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                <div class="mb-6">
                {{ __("You're logged in!") }}
                </div>

                <div class="bg-white border rounded-lg p-4">
                    <h3 class="text-lg font-semibold mb-3">Reservations by Status</h3>
                    <div class="relative h-[800px]">
                        <canvas
                            id="reservationsByStatusChart"
                            data-labels='@json($labels)'
                            data-counts='@json($counts)'
                        ></canvas>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>