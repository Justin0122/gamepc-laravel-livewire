<div>
    <div class="grid grid-cols-6">
        <div class="col-span-1">
            <ul class="border-2 border-gray-300 p-2 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-gray-300 mb-4 mr-4">
                @foreach($partTypes as $field)
                    <li wire:navigate.hover href="{{ route('crudpcparts', ['type' => strtolower($field)]) }}"
                        class="cursor-pointer hover:text-teal-500 transition duration-300 ease-in-out {{ request()->type == strtolower($field) ? 'text-teal-500' : '' }}">
                    {{ ucfirst($field) }}
                @endforeach
            </ul>
        </div>
    <div class="p-6 text-gray-900 dark:text-gray-100 col-span-5 bg-gray-100 dark:bg-gray-800">
        <div class="mb-4 mt-2">
        </div>

        @if($fields)
            <form wire:submit="createPart">
                @foreach($fields as $field)
                    @if(Str::startsWith($field, 'FK')) @continue @endif
                    <div class="mb-4 mt-2 w-1/2 mx-auto">
                        <label class="block text-gray-700 text-sm font-bold mb-2 dark:text-gray-300"
                               for="{{ $field }}">
                            {{ $field }}
                        </label>
                        <input wire:model.lazy="form.{{ $field }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-300" id="{{ $field }}" type="text" placeholder="{{ $field }}">
                    </div>
                @endforeach
                    @foreach($dropdownData as $key => $data)
                        <div class="mb-4 mt-2 w-1/2 mx-auto">
                            <label class="block text-gray-700 text-sm font-bold mb-2 dark:text-gray-300"
                                   for="{{ $key }}">
                                {{ substr($key, 2, -2) }}
                                <select wire:model.lazy="form.{{ $key }}" class="border-2 border-gray-300 p-2 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-gray-300">
                                    <option value="0">{{ $data->first()->Name }}</option>
                                    @foreach($data as $item)
                                        <option value="{{ $item->id }}">{{ $item->Name }}</option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                    @endforeach
                <div class="justify-end flex">
                    <x-button class="ml-4">
                        {{ __('Create') }}
                    </x-button>
                </div>
        @endif
    </div>

    </div>

    <x-notification />
</div>
