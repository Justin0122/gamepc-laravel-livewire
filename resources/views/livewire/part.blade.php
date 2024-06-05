<div>
    <x-notification />
    @can('edit products')
    <x-form-section submit="updatePart">
    <form wire:submit.prevent="updatePart" class="mt-6 space-y-6">
        <x-slot name="title">
            {{ __('Change part details') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Change your current part information.') }}
        </x-slot>

        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Update part') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Update your part.') }}
            </p>
        </header>

        <x-slot name="form">
            <div class="col-span-6 sm:col-span-6">
                <div class="col-span-3">
                    <x-label for="Name" value="Name" />
                    <x-input id="{{ $part->Name }}" type="text" class="mt-1 block w-1/2" wire:model="form.Name" />
                </div>
                <x-section-border />
            </div>

            <div class="col-span-6 sm:col-span-6">
                @php
                    $attributes = $part->getAttributes();
                    array_pop($attributes);
                @endphp
                @foreach($attributes as $key => $value)
                    @php $excludeFields = ['created_at', 'updated_at', 'id', 'deleted_at']; @endphp
                    @if (!in_array($key, $excludeFields) && !Str::startsWith($key, 'FK') && $key != 'Name')
                        <x-label for="{{ $key }}" value="{{ __($key) }}" class="pt-4"/>
                        <x-input id="{{ $key }}" type="text" class="mt-1 block w-full" wire:model="form.{{ $key }}" />
                    @endif
                @endforeach
                <x-section-border />
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-action-message class="mr-3" on="saved">
                {{ __('Saved.') }}
            </x-action-message>

            <x-button wire:loading.attr="disabled" wire:target="updatePart">
                {{ __('Save') }}
            </x-button>
        </x-slot>

    </form>
    </x-form-section>
        @can('delete products')
            <div class="bottom-0 right-0 px-4 py-3">
                @if (!$part->deleted_at)
                    <div class="bottom-0 right-0 px-4 py-3">
                        <x-danger-button class="bg-red-500 hover:bg-red-700" wire:click="deletePart()">
                            {{ __('Delete part') }}
                        </x-danger-button>
                    </div>
                @else
                    <div class="bottom-0 right-0 px-4 py-3">
                        <x-secondary-button class="bg-green-500 hover:bg-green-700" wire:click="restorePart()">
                            {{ __('Restore part') }}
                        </x-secondary-button>
                    </div>
                @endif
            </div>
            <x-notification />
        @endcan
        <x-section-border />

        <div class="text-center text-2xl font-bold text-gray-900 dark:text-gray-100">
            {{ __('Change part images') }}
            <form wire:submit="savePhoto" class="mt-6 space-y-6 flex flex-col items-center">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="large_size">Images</label>
                <input class="block w-1/4 text-lg text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="large_size" type="file" wire:model="images" multiple>

                <x-button class="bg-blue-500 hover:bg-blue-700" wire:loading.attr="disabled" wire:target="savePhoto">
                    {{ __('Save photo') }}
                </x-button>
            </form>

            <div class="image-preview grid grid-cols-3">
                @foreach($images as $photo)
                    <div class="image-container w-64 h-64">
                        <img src="{{ $photo->temporaryUrl() }} " alt="{{ $part->Name }}">
                    </div>
                @endforeach
            </div>
        </div>

        <x-section-border />

        <div class="text-center text-2xl font-bold text-gray-900 dark:text-gray-100 pb-5">
            {{ __('Current photos')}}
            <div class="image-preview grid grid-cols-3">
                @foreach($photos as $photo)
                    <div class="image-container w-64 h-64">
                        <img src="{{ asset('storage/' . $photo) }}" alt="{{ $part->Name }}">
                        @php $fileName = explode('/', $photo); $fileName = end($fileName); @endphp
                        <x-danger-button class="bg-red-500 hover:bg-red-700" wire:click="deletePhoto('{{ $fileName }}')"
                                         wire:confirm="Are you sure you want to delete this photo?">
                            {{ __('Delete photo') }}
                        </x-danger-button>
                    </div>
                @endforeach
            </div>
        </div>
        <x-section-border />
        <div class="text-center text-2xl font-bold text-gray-900 dark:text-gray-100">
            {{ __('Part preview') }}
        </div>

    @endcan

@if(optional(auth()->user())->can('see products') || !auth()->user())
        <div class="py-12">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
                <div class="flex flex-col md:flex-row -mx-4">
                    <div class="md:flex-1 px-4">
                        <div class="h-64 md:h-96 rounded-lg bg-gray-100 dark:bg-gray-700 mb-4">
                            @if (count($photos) > 1)
                                <div id="controls-carousel" class="relative w-full" data-carousel="static">
                                    <!-- Carousel wrapper -->
                                    <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                                        @foreach($photos as $photo)
                                            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                                <img src="{{ asset('storage/' . $photo) }}"
                                                     class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
                                            </div>
                                        @endforeach
                                    </div>
                                    <!-- Slider controls -->
                                    <button type="button" class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                                            <svg class="w-4 h-4 text-white dark:text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                                            </svg>
                                            <span class="sr-only">Previous</span>
                                        </span>
                                    </button>
                                    <button type="button" class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                                            <svg class="w-4 h-4 text-white dark:text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                            </svg>
                                            <span class="sr-only">Next</span>
                                        </span>
                                    </button>
                                </div>

                            @elseif(count($photos) == 1)
                                <img class="w-full h-full object-cover rounded-lg" src="{{ asset('storage/' . $photos[0]) }}" alt="No image">
                            @else
                                <img class="w-full h-full object-cover rounded-lg" src="https://via.placeholder.com/1600" alt="No image">
                            @endif

                        </div>
                        <div class="flex -mx-2 mb-4">
                            @if (auth()->user() && auth()->user()->can('build pc'))
                            <x-button class="bg-teal-500 hover:bg-teal-700 mx-2 dark:bg-teal-500 dark:hover:bg-teal-700" wire:click="addToBuild()">
                                {{ __('Add to build') }}
                            </x-button>
                            @endif
                            @guest
                                <button onclick="add('{{ $this->partType }}', {{ $part->id }}, '{{ $part->Name }}', '{{ $part->Price }}', '{{ $part->image }}')" class="bg-teal-400 hover:bg-teal-500 text-white font-bold py-2 px-4 dark:text-gray-300 dark:border-teal-400 dark:hover:border-teal-500 border-teal-400 border-2 hover:border-teal-500 focus:outline-none focus:shadow-outline rounded-lg">
                                        Add to build
                                </button>
                            @endguest
                        </div>
                    </div>
                    <div class="md:flex-1 px-4">
                        <h2 class="text-gray-600 text-3xl mb-4 dark:text-gray-300">{{ $part->Name }}</h2>
                        <div class="flex mb-4">
                            <div class="mr-4">
                                <span class="font-bold text-gray-700 dark:text-gray-300">Price:</span>
                                <span class="text-gray-600 dark:text-gray-400">€{{ $part->Price}}</span>
                            </div>
                            <div>
                                <span class="font-bold text-gray-700 dark:text-gray-300">Availability:</span>
                                    @if ($part->Stock > 10)
                                        <span class="text-green-600 dark:text-green-400">In Stock</span>
                                    @elseif ($part->Stock > 0)
                                        <span class="text-orange-600 dark:text-orange-400">Only {{ $part->Stock }} left</span>
                                    @else
                                        <span class="text-red-600 dark:text-red-400">Out of Stock</span>
                                    @endif
                            </div>
                        </div>
                        <div>
                            @if ($part->Description)
                            <span class="font-bold text-gray-700 dark:text-gray-300">Product Description:</span>
                            <p class="text-gray-600 text-sm mt-2 dark:text-gray-400">
                                {{ $part->Description}}
                            </p>
                            @endif
                        </div>

                            @foreach($part->getAttributes() as $key => $value)
                            @php $excludeFields = ['Name', 'created_at', 'updated_at', 'id', 'deleted_at', 'image', 'Stock', 'Price']; @endphp
                            @if (!in_array($key, $excludeFields) && !Str::startsWith($key, 'FK'))
                                <div class="flex mb-4">
                                    <div class="mr-4">
                                        <span class="font-bold text-gray-700 dark:text-gray-300">{{ $key }}:</span>
                                        <span class="text-gray-600 dark:text-gray-400">{{ $value }}</span>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @foreach($fields as $key => $value)
                            @php $excludeFields = ['Name', 'created_at', 'updated_at', 'id', 'deleted_at', 'image', 'Stock', 'Price']; @endphp
                            @if (!in_array($key, $excludeFields) && !Str::startsWith($key, 'FK'))
                                <div class="flex mb-4">
                                    <div class="mr-4">
                                        <span class="font-bold text-gray-700 dark:text-gray-300">{{ $key }}:</span>
                                        <span class="text-gray-600 dark:text-gray-400">{{ $value }}</span>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

        <script type="text/javascript">

            function add($partType, $partId, $partName, $partPrice, $partImage){
                const part = {
                    partType: $partType,
                    partId: $partId,
                    partName: $partName,
                    partPrice: $partPrice,
                    partImage: $partImage
                };
                let parts = JSON.parse(localStorage.getItem('parts'));
                if(parts == null){
                    parts = [];
                }
                for (var i = 0; i < parts.length; i++) {
                    if(parts[i].partType === part.partType){
                        parts[i].partId = part.partId;
                        localStorage.setItem('parts', JSON.stringify(parts));
                        return;
                    }
                }
                parts.push(part);
                localStorage.setItem('parts', JSON.stringify(parts));
            }
        </script>

        @auth

            <script type="text/javascript">
                window.onload = function() {
                    const parts = JSON.parse(localStorage.getItem('parts'));
                    if(parts != null){
                        parts.forEach(part => {
                            @this.addToBuild(part.partType, part.partId);
                        });
                        localStorage.removeItem('parts');
                    }
                }
            </script>
        @endauth
    @endif
</div>
