<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My PC') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid-cols-3">
                        <div class="grid-rows-1">
                            <livewire:user.mypc />

                        </div>
                        <div class="grid-rows-1">
                            <livewire:profile.update-address-form />

                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="m-2">
                        <livewire:Transaction />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
