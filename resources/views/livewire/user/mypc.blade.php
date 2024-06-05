<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mb-3 rounded relative" role="alert" id="sessionMessage">
            <span class="block sm:inline">{{ session('message') }}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg wire:click="$set('showMessage', false)" class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <title>Close</title>
                    <path d="M14.348 14.849a1 1 0 0 1-1.414 0L10 11.414l-2.93 2.93a1 1 0 1 1-1.414-1.414l2.93-2.93-2.93-2.93a1 1 0 1 1
                    1.414-1.414l2.93 2.93 2.93-2.93a1 1 0 1 1 1.414 1.414l-2.93
                    2.93 2.93 2.93a1 1 0 0 1 0 1.414z"/>
                </svg>
            </span>
        </div>
    @endif

    @auth
            <script type="text/javascript">
                function syncBuild(){
                    const parts = JSON.parse(localStorage.getItem('parts'));
                    if(parts != null){
                        parts.forEach(part => {
                            @this.addToBuild(part.partType, part.partId);
                        });
                        localStorage.removeItem('parts');
                    }
                }
                window.onload = function() {
                    const parts = JSON.parse(localStorage.getItem('parts'));
                    //unhide the sync button if there are parts in local storage
                    if(parts != null){
                        document.getElementById('sync').classList.remove('hidden');
                    }
                }
            </script>
            <button onclick="syncBuild()" id="sync" class="hidden bg-teal-400 hover:bg-teal-500 text-white font-bold py-2 px-4 dark:text-gray-300 dark:border-teal-400 dark:hover:border-teal-500 border-teal-400 border-2 hover:border-teal-500 focus:outline-none focus:shadow-outline rounded-lg">
                Sync build
            </button>
        <div class="max-w-3xl mx-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                <tr>
                    <th class="text-left text-gray-500 dark:text-gray-300 uppercase">Component</th>
                    <th class="text-left text-gray-500 dark:text-gray-300 uppercase">Image</th>
                    <th class="text-left text-gray-500 dark:text-gray-300 uppercase">Name</th>
                    <th class="text-left text-gray-500 dark:text-gray-300 uppercase">Price</th>
                    <th class="text-left text-gray-500 dark:text-gray-300 uppercase"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($fields as $field)
                    <tr>
                        <td class="py-2">
                            <h1 class="text-2xl font-bold leading-none text-gray-900 dark:text-gray-100 mr-1">
                                {{ ucwords(str_replace('_', ' ', $field)) }}
                            </h1>
                        </td>
                        <td class="py-2">
                            @php
                                $attributes = $parts[0]->getAttributes();
                                $fieldId = $attributes[$field . 'Id'];
                                $directory = public_path('storage/parts/' . strtolower($field) . '/' . $fieldId);
                                $images = array_values(array_filter(scandir($directory), function($file) {
                                    return !is_dir($file) && in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']);
                                }));

                                if (empty($images)) {
                                    $firstImage = 'https://via.placeholder.com/150';
                                } else {
                                    $firstImage = asset('storage/parts/' . strtolower($field) . '/' . $fieldId . '/' . $images[0]);
                                }
                            @endphp
                            @if (isset($parts[0][$field . 'Id']) && $parts[0][$field . 'Id'] != null)
                            <img src="{{ $firstImage }}" alt="{{ $parts[0][$field . 'Name'] }}" class="w-32 h-32 object-cover rounded-lg shadow-md">
                            @endif
                        </td>


                        <td class="py-2">
                            @if (isset($parts[0][$field . 'Id']) && $parts[0][$field . 'Id'] != null)
                            <a wire:navigate href="/part/{{ strtolower($field) }}?id={{ $parts[0][$field . 'Id'] }}"
                               class="text-blue-500 hover:text-blue-700">{{ $parts[0][$field . 'Name'] }}</a>
                            @endif
                        </td>
                        <td class="py-2">
                            @if (isset($parts[0][$field . 'Id']) && $parts[0][$field . 'Id'] != null)
                            <h1 class="text-2xl font-bold leading-none text-gray-900 dark:text-gray-100 mr-1">{{ $parts[0][$field . 'Price'] }}</h1>
                            @endif
                        </td>
                        <td class="py-4">
                            @if (!isset($parts[0][$field . 'Id']) || $parts[0][$field . 'Id'] == null)
                                <a href="{{ route('parts', ['type' => strtolower($field)]) }}">
                                    <x-secondary-button>
                                        Add
                                    </x-secondary-button>
                                </a>
                            @else
                                <button wire:click="removeFromBuild('{{ strtolower($field) }}', {{ $parts[0][$field . 'Id'] }})"
                                        class="bg-red-400 hover:bg-red-500 text-white font-bold py-2 px-4 dark:text-gray-300 dark:border-red-400 dark:hover:border-red-500 border-red-400 border-2 hover:border-red-500 focus:outline-none focus:shadow-outline rounded-lg">
                                    Remove
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td class="py-2">
                        <h1 class="text-2xl font-bold leading-none text-gray-900 dark:text-gray-100 mr-1">
                            Total
                        </h1>
                    </td>
                    <td class="py-2">
                        <h1 class="text-2xl font-bold leading-none text-gray-900 dark:text-gray-100 mr-1">{{ $total }}</h1>
                    </td>
                    <td class="py-2">
                        <button wire:click="clearBuild" class="bg-red-400 hover:bg-red-500 text-white font-bold py-2 px-4 dark:text-gray-300 dark:border-red-400 dark:hover:border-red-500 border-red-400 border-2 hover:border-red-500 focus:outline-none focus:shadow-outline rounded-lg">
                            Clear
                        </button>
                    </td>
                    <td class="py-2">
                        <a wire:navigate href="{{ route('checkout') }}" class="bg-teal-400 hover:bg-teal-500 text-white font-bold py-2 px-4 dark:text-gray-300 dark:border-teal-400 dark:hover:border-teal-500 border-teal-400 border-2 hover:border-teal-500 focus:outline-none focus:shadow-outline rounded-lg">
                            Checkout
                        </a>
                    </td>
                </tfoot>
            </table>
        </div>
    @endauth

    @guest
        @php $partTypes = ['Cpu', 'Cpu_cooler', 'Motherboard', 'Ram', 'Storage', 'Gpu', 'Psu', 'Pc_Case', 'Case_cooler']; @endphp
            <div class="max-w-3xl mx-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead>
                    <tr>
                        <th class="text-left text-gray-500 dark:text-gray-300 uppercase">Component</th>
                        <th class="text-left text-gray-500 dark:text-gray-300 uppercase">Name</th>
                        <th class="text-left text-gray-500 dark:text-gray-300 uppercase">Price</th>
                        <th class="text-left text-gray-500 dark:text-gray-300 uppercase"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($partTypes as $type)
                        <tr>
                            <td class="py-2">
                                <h1 class="text-2xl font-bold leading-none text-gray-900 dark:text-gray-100 mr-1">
                                    {{ ucwords(str_replace('_', ' ',$type)) }}
                                </h1>
                            </td>
                            <td class="py-2">
                                <a wire:navigate href="/part/{{ strtolower($type) }}" class="text-blue-500 hover:text-blue-700" id="{{ strtolower($type) }}"></a>
                            </td>
                            <td class="py-2">
                                <h1 class="text-2xl font-bold leading-none text-gray-900 dark:text-gray-100 mr-1" id="{{ strtolower($type) }}Price"></h1>
                            </td>
                            <td class="py-4">
                                <button onclick="removeFromBuild('{{ strtolower($type) }}')" class="bg-red-400 hover:bg-red-500 text-white font-bold py-2 px-4 dark:text-gray-300 dark:border-red-400 dark:hover:border-red-500 border-red-400 border-2 hover:border-red-500 focus:outline-none focus:shadow-outline rounded-lg">
                                    Remove
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td class="py-2">
                            <h1 class="text-2xl font-bold leading-none text-gray-900 dark:text-gray-100 mr-1">
                                Total
                            </h1>
                        </td>
                        <td class="py-2">
                            <h1 class="text-2xl font-bold leading-none text-gray-900 dark:text-gray-100 mr-1" id="total"></h1>
                        </td>
                        <td class="py-2">
                            <button onclick="clearStorage()" class="bg-red-400 hover:bg-red-500 text-white font-bold py-2 px-4 dark:text-gray-300 dark:border-red-400 dark:hover:border-red-500 border-red-400 border-2 hover:border-red-500 focus:outline-none focus:shadow-outline rounded-lg">
                                Clear
                            </button>
                        </td>
                        <td class="py-2">
                            <a href="{{ route('login') }}">
                                <x-secondary-button>
                                    Login to checkout
                                </x-secondary-button>
                            </a>
                        </td>
                    </tfoot>
                </table>
            </div>

            <script type="text/javascript">
                parts = JSON.parse(localStorage.getItem('parts'));
            if(parts == null){
                parts = [];
            }
            console.log(parts);
            total = 0;
            for (let i = 0; i < parts.length; i++) {
                total += parseFloat(parts[i].partPrice);
            }
            document.getElementById('total').innerHTML = total.toFixed(2);
            for (let i = 0; i < parts.length; i++) {
                document.getElementById(parts[i].partType.toLowerCase()).innerHTML = parts[i].partName;
                document.getElementById(parts[i].partType.toLowerCase() + 'Price').innerHTML = parts[i].partPrice;
            }
        </script>
        @endguest

        <script type="text/javascript">
            function clearStorage() {
                localStorage.removeItem('parts');
                location.reload();
            }

            function removeFromBuild($partType){
                let parts = JSON.parse(localStorage.getItem('parts'));
                for (var i = 0; i < parts.length; i++) {
                    if(parts[i].partType === $partType){
                        parts.splice(i, 1);
                        localStorage.setItem('parts', JSON.stringify(parts));
                        location.reload();
                        return;
                    }
                }
            }
        </script>
</div>
