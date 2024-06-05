<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ request()->type ? ucfirst(request()->type) : 'Select' }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4">
        @php $types = ['brand', 'form-factor', 'socket', 'generation']; @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
            <div class="col-span-1 filter flex flex-col mt-20">
                <ul class="border-2 border-gray-300 p-2 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-gray-300 mb-4">
                    @foreach($types as $field)
                        <li wire:navigate.hover href="{{ route('crud', ['type' => $field]) }}"
                            class="cursor-pointer hover:text-teal-500 transition duration-300 ease-in-out {{ request()->type == $field ? 'text-teal-500' : '' }}">
                            {{ ucfirst($field) }}
                    @endforeach
                </ul>
            </div>
            <div class="col-span-5">

            @if (in_array(request()->type, $types))
                @livewire(request()->type)
            @endif
            </div>
        </div>
    </div>
</x-app-layout>
