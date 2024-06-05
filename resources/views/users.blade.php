<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8 w-3/4">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <livewire:UserListView />
            </div>
        </div>
    </div>
</x-app-layout>
