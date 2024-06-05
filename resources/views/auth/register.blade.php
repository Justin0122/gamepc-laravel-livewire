<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-label for="name" :value="__('Firstname')" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :for="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <x-label for="insertion" :value="__('Insertion')" />
                <x-input id="insertion" class="block mt-1 w-full" type="text" name="insertion" :value="old('insertion')" autofocus autocomplete="insertion" />
                <x-input-error :for="$errors->get('insertion')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-label for="last_name" :value="__('Lastname')" />
                <x-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autocomplete="last_name" />
                <x-input-error :for="$errors->get('last_name')" class="mt-2" />
            </div>

            <!-- Username -->
            <div class="mt-4">
                <x-label for="username" :value="__('Username')" />
                <x-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autocomplete="username" />
                <x-input-error :for="$errors->get('username')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :for="$errors->get('email')" class="mt-2" />
            </div>

            <!-- City -->
            <div class="mt-4">
                <x-label for="city" :value="__('City')" />
                <x-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city')" required autocomplete="city" />
                <x-input-error :for="$errors->get('city')" class="mt-2" />
            </div>

            <!-- Street -->
            <div class="mt-4">
                <x-label for="street" :value="__('Street')" />
                <x-input id="street" class="block mt-1 w-full" type="text" name="street" :value="old('street')" required autocomplete="street" />
                <x-input-error :for="$errors->get('street')" class="mt-2" />
            </div>

            <!-- House Number -->
            <div class="mt-4">
                <x-label for="house_number" :value="__('House Number')" />
                <x-input id="house_number" class="block mt-1 w-full" type="text" name="house_number" :value="old('house_number')" required autocomplete="house_number" />
                <x-input-error :for="$errors->get('house_number')" class="mt-2" />
            </div>

            <!-- Postcode -->
            <div class="mt-4">
                <x-label for="postcode" :value="__('Postcode')" />
                <x-input id="postcode" class="block mt-1 w-full" type="text" name="postcode" :value="old('postcode')" required autocomplete="postcode" />
                <x-input-error :for="$errors->get('postcode')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
