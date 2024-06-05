@if (session()->has('message'))
    @php
        $classes = 'bg-green-100 border-green-400 text-green-700';
        if (str_contains(session('message'), 'Deleted') !== false) {
            $classes = 'bg-red-100 border-red-400 text-red-700';
        } elseif (str_contains(session('message'), 'Restored') !== false) {
            $classes = 'bg-blue-100 border-blue-400 text-blue-700';
        }
    @endphp

    <div class="{{$classes }} px-4 py-3 mb-3 rounded relative border"
         role="alert"
         id="sessionMessage">
        <span class="block sm:inline">{{ session('message') }}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg wire:click="$set('showMessage', false)" class="fill-current h-6 w-6 text-teal-400" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <title>Close</title>
                    <path d="M14.348 14.849a1 1 0 0 1-1.414 0L10 11.414l-2.93 2.93a1 1 0 1 1-1.414-1.414l2.93-2.93-2.93-2.93a1 1 0 1 1
                    1.414-1.414l2.93 2.93 2.93-2.93a1 1 0 1 1 1.414 1.414l-2.93
                    2.93 2.93 2.93a1 1 0 0 1 0 1.414z"/>
                </svg>
            </span>
    </div>
@endif
