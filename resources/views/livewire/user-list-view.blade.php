<div class="flex flex-col mt-8 shadow-lg rounded-lg overflow-x-auto dark:text-gray-300">
    <label>
        <select wire:model.live="selectedRole" class="border-2 border-gray-300 p-2 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-gray-300">
            <option value="0">All</option>
            @foreach ($roleOptions as $roleOption)
                <option value="{{ $roleOption->name }}">{{ $roleOption->name }}</option>
            @endforeach
        </select>
    </label>

    <label>
        <input type="text" wire:model.live="search" class="border-2 border-gray-300 p-2 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-gray-300" placeholder="Search...">
    </label>

    <table class="table-auto w-full text-left whitespace-no-wrap dark:text-gray-300">
        <thead class="text-xs uppercase font-semibold bg-gray-100 dark:bg-gray-900 text-gray-600 dark:text-gray-300">
        <tr class="text-left">
            @php $includedFields = ['name', 'insertion', 'last_name', 'username', 'email', 'city', 'street', 'house_number', 'postcode']; @endphp
            <th class="font-semibold text-sm uppercase px-2 py-3">Photo</th>
            @foreach ($includedFields as $field)
                <th class="font-semibold text-sm uppercase px-2 py-3">{{ $field }}</th>
            @endforeach
            @can('edit roles')
            <th class="font-semibold text-sm uppercase px-2 py-3">Role</th>
            @endcan
        </tr>
        </thead>
        <tbody>
        @forelse ($filteredUsers as $user)
            <tr>
                <td class="p-2 bg-gray-100 dark:bg-gray-700 dark:text-gray-300 border-b-2 border-gray-200 dark:border-gray-800">
                    <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="rounded-full h-8 w-8">
                </td>
                @foreach ($includedFields as $field)
                    <td class="p-2 bg-gray-100 dark:bg-gray-700 dark:text-gray-300 border-b-2 border-gray-200 dark:border-gray-800">{{ $user->$field }}</td>
                @endforeach
                @can('edit roles')
                <td class="p-2 bg-gray-100 dark:bg-gray-700 dark:text-gray-300 border-b-2 border-gray-200 dark:border-gray-800">
                    <label>
                        <select wire:change="changePermission({{ $user->id }})" wire:model="roleName.{{ $user->id }}" class="border-2 border-gray-300 p-2 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-gray-300">
                            <option value="{{ $user->getRoleNames()->first() }}">{{ $user->getRoleNames()->first() }}</option>
                            @foreach ($roleOptions as $roleOption)
                                <option value="{{ $roleOption->name }}">{{ $roleOption->name }}</option>
                            @endforeach
                        </select>
                    </label>
                </td>
                @endcan
            </tr>
        @empty
            <tr>
                <td colspan="10">No users found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

</div>
