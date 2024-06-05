<x-form-section submit="updateAddress">
    <form wire:submit.prevent="updateAddress" class="mt-6 space-y-6">
    <x-slot name="title">
            {{ __('Change Address') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Change your current address information.') }}
        </x-slot>

    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Update address') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Update your account\'s address.') }}
        </p>
    </header>

        <x-slot name="form">
                <!-- City -->
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="city" value="{{ __('City') }}" />
                    <x-input id="city" type="text" class="mt-1 block w-full" wire:model="city" required autocomplete="city" />
                    <x-input-error for="city" class="mt-2" />
                </div>

                <!-- Street -->
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="street" value="{{ __('Street') }}" />
                    <x-input id="street" type="text" class="mt-1 block w-full" wire:model="street" required autocomplete="street" />
                    <x-input-error for="street" class="mt-2" />
                </div>

                <!-- House Number -->
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="house_number" value="{{ __('House Number') }}" />
                    <x-input id="house_number" type="text" class="mt-1 block w-full" wire:model="house_number" required autocomplete="house_number" />
                    <x-input-error for="house_number" class="mt-2" />
                </div>

                <!-- Postcode -->
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="postcode" value="{{ __('Postcode') }}" />
                    <x-input id="postcode" type="text" class="mt-1 block w-full" wire:model="postcode" required autocomplete="postcode" />
                    <x-input-error for="postcode" class="mt-2" />
                </div>

        </x-slot>

            <x-slot name="actions">
                <x-action-message class="mr-3" on="saved">
                    {{ __('Saved.') }}
                </x-action-message>

                <x-button wire:loading.attr="disabled" wire:target="photo">
                    {{ __('Save') }}
                </x-button>
            </x-slot>
    </form>
</x-form-section>

