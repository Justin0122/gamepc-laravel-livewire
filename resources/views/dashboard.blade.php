<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3 pr-3">

                        @include('home-cards')
                    </div>

            @if (optional(Auth::user())->can('build pc') || !Auth::user())
                <div class="text-3xl text-center font-bold text-gray-800 dark:text-gray-200 mt-24 mb-5">
                    Can't decide?
                </div>
                <div class="text-xl text-center font-bold text-gray-800 dark:text-gray-200 mb-5">
                    Check out these random products!
                </div>

                <livewire:random-products/>
            @endif
        </div>
    </div>
</x-app-layout>
