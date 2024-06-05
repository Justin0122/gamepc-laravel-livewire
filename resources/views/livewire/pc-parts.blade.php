<div>
    <x-notification />
    <div class="flex justify-center items-center">
    <x-input type="text" class="border-2 border-teal-400 p-2 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-gray-300 mb-4" placeholder="Search parts..." wire:model.live="search"/>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-6 gap-6">
        <div class="mb-4 md:col-span-1">
            <ul class="border-2 border-gray-300 p-2 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-gray-300 mb-4">
                @foreach($fields as $field)
                    <li wire:click="$set('partType', '{{ strtolower($field) }}')"
                        class="cursor-pointer hover:text-teal-500 transition duration-300 ease-in-out {{ $partType === strtolower($field) ? 'text-teal-500 font-bold' : '' }}">
                        {{ str_replace('_', ' ', $field) }}
                    </li>
                @endforeach
            </ul>

            <div class="applied-filters">
                @if($appliedFilters)
                    <h1 class="text-xl font-bold leading-none text-gray-900 dark:text-gray-100 mr-1 pb-2">Applied filters</h1>
                    @foreach($appliedFilters as $filterName => $filterValue)
                        <div class="flex justify-between items-center bg-gray-100 dark:bg-gray-700 dark:text-gray-300 p-2 rounded-lg mb-4">
                            <h1 class="text-xl font-bold leading-none text-gray-900 dark:text-gray-100 mr-1">
                                {{ ucwords(str_replace('_', ' ', $filterName)) }}</h1>
                            <div class="flex flex-wrap">
                                <ul>
                                    <li class="cursor-pointer hover:text-red-500 transition duration-300 ease-in-out"
                                        wire:click="clearFilter('{{ $filterName }}')">
                                        {{ $filterValue }}
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 inline-block"
                                             viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L10 8.586 7.707 6.293a1 1 0 00-1.414 1.414L8.586 10l-2.293 2.293a1 1 0 101.414 1.414L10 11.414l2.293 2.293a1 1 0 001.414-1.414L11.414 10l2.293-2.293z"
                                                  clip-rule="evenodd"/>
                                        </svg>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            @foreach ($filters as $filterName => $filterValues)
                <x-input type="text" class="border-2 border-teal-400 p-2 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-gray-300 mb-4" placeholder="Search {{ ucwords(str_replace('_', ' ', $filterName)) }}..." wire:model.live="filterSearch.{{ $filterName }}"/>
                <ul>
                    <li class="border-2 border-gray-300 p-2 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-gray-300 mb-4">
                        <h1 class="text-xl font-bold leading-none text-gray-900 dark:text-gray-100 mr-1">
                            {{ ucwords(str_replace('_', ' ', $filterName)) }}</h1>
                        <div class="flex flex-wrap">
                            <ul>
                            @foreach ($filterValues as $filterValue)
                                <li class="cursor-pointer hover:text-teal-500 transition duration-300 ease-in-out"
                                    wire:click="addFilter('{{ $filterName }}', '{{ $filterValue->Name }}')">
                                    {{ $filterValue->Name }}
                                </li>
                            @endforeach
                            </ul>
                        </div>
                    </li>
                </ul>
            @endforeach
        </div>

    @if ($parts->count() === 0)
        <div class="flex justify-center items-center col-span-5 shadow-lg p-4">
            <div class="text-center">
                <h1 class="text-2xl font-bold text-gray-700 dark:text-gray-300">No parts found</h1>
                <p class="text-gray-500 dark:text-gray-400">Try searching for something else</p>
            </div>
        </div>
    @else
            <div class="col-span-5 dark:text-gray-300 dark:bg-gray-700 dark:border-gray-600 border-collapse shadow-lg overflow-y-scroll max-h-screen overflow-x-hidden px-5">
                @if($myPcParts)
                    @if($myPcParts->{'FK' . str_replace('Pc', '', str_replace(' ', '', ucwords(str_replace('_', ' ',$partType)))) . 'Id'} == null)
                        <div class="flex justify-center items-center">
                            <h1 class="text-2xl font-bold text-gray-700 dark:text-gray-300">Select a {{ str_replace('_', ' ', $partType) }} for your build</h1>
                        </div>
                    @else
                        <div class="flex justify-center items-center">
                            <div class="text-center">
                                <h1 class="text-2xl font-bold text-gray-700 dark:text-gray-300">You already have a {{ str_replace('_', ' ', $partType) }} in your build</h1>
                                <p class="text-gray-500 dark:text-gray-400">You can select a different {{ str_replace('_', ' ', $partType) }} or remove it from your build</p>
                            </div>
                        </div>
                        @endif
                @endif
            <table class="table-auto w-full">
                <thead>
                <tr>
                    <th class="p-2 bg-gray-100 dark:bg-gray-700 dark:text-gray-300 border-b-2 border-gray-200 dark:border-gray-800"></th>
                    @foreach($parts[0]->getAttributes() as $key => $value)
                        @php $excludeFields = ['created_at', 'updated_at', 'id', 'deleted_at', 'image']; @endphp
                        @if (!in_array($key, $excludeFields) && !Str::startsWith($key, 'FK'))
                            @php $pattern = '/(?<!\s)(?=[A-Z](?![A-Z]))/';
                                    $key = preg_replace($pattern, ' $0', $key);
                            @endphp
                            <th class="p-2 bg-gray-100 dark:bg-gray-700 dark:text-gray-300 border-b-2 border-gray-200 dark:border-gray-800">{{ $key }}</th>
                        @endif
                    @endforeach
                    @can('edit products')
                        <th class="p-2 bg-gray-100 dark:bg-gray-700 dark:text-gray-300 border-b-2 border-gray-200 dark:border-gray-800">
                            @foreach($parts[0]->getAttributes() as $key => $value)
                                @if ($key === 'deleted_at')
                                    {{ $key }}
                                @endif
                            @endforeach
                        </th>
                    @endcan
                    <th class="p-2 dark:border-gray-800 bg-gray-100 dark:bg-gray-700 dark:text-gray-300 border-b-2 border-gray-200"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($parts as $part)

                    <tr class="cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-800 transition duration-300 ease-in-out hover:shadow-lg dark:hover:shadow-xl hover:scale-[1.05]">
                        <td class="flex w-full bg justify-center items-center border-b-2 border-gray-200 dark:border-gray-800">
                            @if ($part->image)
                                <img class="w-16 h-16 object-cover" src="{{ $part->image }}" alt="{{ $part->Name }}">
                            @else
                                <img class="w-16 h-16 object-cover" src="https://via.placeholder.com/150" alt="No image">
                            @endif
                        </td>
                        @foreach($part->getAttributes() as $key => $value)
                            @if (!in_array($key, $excludeFields) && !Str::startsWith($key, 'FK'))
                                <td class="p-2 dark:border-gray-800 dark:text-gray-300 border-b-2 border-gray-200" onclick="window.location='/part/{{ $this->partType }}?id={{ $part->id }}'" >
                                    {{ $value }}
                                </td>
                            @endif
                        @endforeach
                        @can('edit products')
                            <td class="p-2 dark:border-gray-800 dark:text-gray-300 border-b-2 border-gray-200">
                                <!-- show the deleted_at column if the user has the edit products permission -->
                                @foreach($part->getAttributes() as $key => $value)
                                    @if ($key === 'deleted_at')
                                        {{ $value }}
                                    @endif
                                @endforeach
                            </td>
                        @endcan
                        <td class="p-2 dark:border-gray-800 dark:text-gray-300 text-center border-b-2 border-gray-200 w-max">
                            @auth
                                @can('build pc')
                                @if($myPcParts)
                                    @if($myPcParts->{'FK' . str_replace('Pc', '', str_replace(' ', '', ucwords(str_replace('_', ' ',$partType)))) . 'id'} == $part->id)
                                        <button wire:click="removeFromBuild('{{ $this->partType }}')"
                                                class="bg-red-400 hover:bg-red-500 text-white font-bold py-2 px-4 dark:text-gray-300 dark:border-red-400 dark:hover:border-red-500 border-red-400 border-2 hover:border-red-500 focus:outline-none focus:shadow-outline rounded-lg">
                                            Remove
                                        </button>
                                    @else
                                    <button wire:click="addToBuild('{{ $this->partType }}', {{ $part->id }})"
                                            class="bg-teal-400 hover:bg-teal-500 text-white font-bold py-2 px-4 dark:text-gray-300 dark:border-teal-400 dark:hover:border-teal-500 border-teal-400 border-2 hover:border-teal-500 focus:outline-none focus:shadow-outline rounded-lg">
                                            Add to build
                                    </button>
                                    @endif
                                @else
                                    <button wire:click="addToBuild('{{ $this->partType }}', {{ $part->id }})"
                                            class="bg-teal-400 hover:bg-teal-500 text-white font-bold py-2 px-4 dark:text-gray-300 dark:border-teal-400 dark:hover:border-teal-500 border-teal-400 border-2 hover:border-teal-500 focus:outline-none focus:shadow-outline rounded-lg">
                                        Add to build
                                    </button>
                                @endif
                                @endcan
                            @endauth

                            @guest
                                <button onclick="add('{{ $this->partType }}', {{ $part->id }}, '{{ $part->Name }}', '{{ $part->Price }}', '{{ $part->image }}')"
                                        class="bg-teal-400 hover:bg-teal-500 text-white font-bold py-2 px-4 dark:text-gray-300 dark:border-teal-400 dark:hover:border-teal-500 border-teal-400 border-2 hover:border-teal-500 focus:outline-none focus:shadow-outline rounded-lg">
                                    Add to build
                                </button>
                            @endguest

                        </td>
                    </tr>
                @endforeach
                {{ $parts->links() }}
                </tbody>
            </table>
        </div>

    </div>
    @endif

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
</div>
