<?php

namespace App\Actions\Fortify;

use App\AuditTrail;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Spatie\Permission\Models\Role;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'insertion' => ['nullable', 'string', 'max:32'] ?? null,
            'username' => ['string', 'max:32', 'unique:' . User::class],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'min:15', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'],
            'city' => ['required', 'string', 'max:255'],
            'street' => ['required', 'string', 'max:255'],
            'house_number' => ['required', 'string', 'max:6'],
            'postcode' => ['required', 'string', 'max:6'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();



        $customerRole = Role::where('name', 'customer')->first();

        // Assign the "customer" role to the user
        if ($customerRole) {
            $user = User::create([
                'name' => $input['name'],
                'last_name' => $input['last_name'],
                'insertion' => $input['insertion'],
                'username' => $input['username'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'city' => $input['city'],
                'street' => $input['street'],
                'house_number' => $input['house_number'],
                'postcode' => $input['postcode'],
            ]);
            $user->assignRole($customerRole);
        }


        AuditTrail::logUserRegister();

        return $user;

    }
}
