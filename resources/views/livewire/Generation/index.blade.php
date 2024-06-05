<div class="container mx-auto px-4">
    <x-notification />
    @if($this->id)
        @if (request()->type == 'generation')
            <div class="justify-center flex mt-20">
                @include('livewire.crud.edit')
            </div>
        @endif
    @else
        @include('livewire.crud.create')

        {{ $results->links() }}

        <table class="table-auto w-full">
            <thead class="bg-gray-200 dark:bg-gray-700">
            <tr>
                @foreach($fillables as $column)
                    <th class="px-4 py-2">{{ $column }}</th>
                @endforeach
                <th class="px-4 py-2">{{ __('Actions') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($results as $result)
                <tr class="hover:bg-gray-100 transition duration-300 ease-in-out dark:hover:bg-gray-800">
                    @foreach($fillables as $column)
                        <td class="px-4 py-2">{{ $result->$column }}</td>
                    @endforeach
                    <td class="px-4 py-2 flex justify-end">
                        <a wire:navigate.hover href="{{ $url . '?id=' . $result->id }}&type=generation">
                            <x-button class="mr-2">
                                Edit
                            </x-button>
                        </a>
                        <x-danger-button wire:confirm="Are you sure you want to delete this?" wire:click="delete({{ $result->id }})">
                            Delete
                        </x-danger-button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>
