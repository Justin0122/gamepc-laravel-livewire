@if (optional(auth()->user())->can('build pc') || !auth()->user())
    <x-card
        title="My PC"
        description="Build your own PC"
        image="https://i.etsystatic.com/35436991/c/3000/2384/0/64/il/08219f/3828416556/il_340x270.3828416556_opr6.jpg"
        :button="['url' => '/mypc', 'label' => 'Build']"
    />
@endif
@if (optional(auth()->user())->can('see products') || !auth()->user())
    <x-card
        title="View parts"
        description="View all parts in the database"
        image="https://image.coolblue.nl/transparent/max/512x288/content/a80e7b066f50222ca1882a4974589f6f"
        :button="['url' => '/parts', 'label' => 'View']"
    />
@endif

@auth
    @can('see own orders')
        <x-card
            title="View history"
            description="View your order history"
            image="https://thenounproject.com/api/private/icons/3485551/edit/?backgroundShape=SQUARE&backgroundShapeColor=%23000000&backgroundShapeOpacity=0&exportSize=752&flipX=false&flipY=false&foregroundColor=%23000000&foregroundOpacity=1&imageFormat=png&rotation=0"
            :button="['url' => '/history', 'label' => 'View']"
        />
    @endcan

    @can('see orders')
        <x-card
            title="View orders"
            description="View all orders"
            image="https://static.vecteezy.com/system/resources/previews/019/787/018/non_2x/shopping-cart-icon-shopping-basket-on-transparent-background-free-png.png"
            :button="['url' => '/orders', 'label' => 'View']"
        />
    @endcan

    @can('add products')
        <x-card
            title="Add a part"
            description="Add a part to the database"
            image="https://i.etsystatic.com/35436991/c/3000/2384/0/64/il/08219f/3828416556/il_340x270.3828416556_opr6.jpg"
            :button="['url' => '/create_parts', 'label' => 'Add']"
        />
    @endcan

    @can('see customers')
        <x-card
            title="View users"
            description="View all users in the database"
            image="https://img.freepik.com/free-vector/group-people-illustration-set_52683-33806.jpg"
            :button="['url' => '/users', 'label' => 'View']"
        />
    @endcan


    @can('add products')
        <div class="mx-2 mb-8">
            <article class="relative isolate flex flex-col justify-end overflow-hidden rounded-2xl bg-gray-50 dark:shadow-xl dark:bg-gray-700 h-72 w-30 dark:hover:shadow-2xl transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-103 hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-gray-100 dark:hover:drop-shadow-2xl sm:mx-auto sm:max-w-xl md:max-w-full">
                <div class="absolute inset-0 bg-gradient-to-t dark:from-gray-900 dark:via-gray-900/40 from-teal-900 via-teal-900/40">
                    <h3 class="z-10 mt-3 text-3xl font-bold text-white pl-4">
                        CRUD
                    </h3>
                    <ul class="border-2 border-gray-300 dark:border-gray-600 p-2 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-gray-300 mb-4 h-56 overflow-y-scroll">
                        @php $types = ['brand', 'form-factor', 'socket', 'generation']; @endphp

                    @foreach($types as $field)
                            <li wire:navigate.hover href="{{ route('crud', ['type' => $field]) }}"
                                class="cursor-pointer hover:text-teal-500 transition duration-300 ease-in-out {{ request()->type == $field ? 'text-teal-500' : '' }}">
                            {{ ucfirst($field) }}
                        @endforeach
                    </ul>
                </div>
            </article>
        </div>

    @endcan
@endauth




@guest
<x-card
    title="Register"
    description="Register an account"
    image="https://static.thenounproject.com/png/736670-200.png"
    :button="['url' => '/register', 'label' => 'Register']"
    :secondary-button="['url' => '/login', 'label' => 'Login']"
/>
@endguest
