<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Parts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w mx-auto sm:px-6 lg:px-8">

            <div class="p-6 text-gray-900 dark:text-gray-100 overflow-hidden shadow-xl sm:rounded-lg backdrop-blur bg-gray-100 dark:bg-gray-800">
                <livewire:pc-parts />
            </div>
        </div>
    </div>
</x-app-layout>
