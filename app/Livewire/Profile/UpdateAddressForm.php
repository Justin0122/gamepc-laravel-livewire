<?php

namespace App\Livewire\Profile;

use App\AuditTrail;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UpdateAddressForm extends Component
{
    public string $city = '';

    public string $street = '';
    public string $house_number = '';
    public string $postcode = '';

    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $this->city = auth()->user()->city;
        $this->street = auth()->user()->street;
        $this->house_number = auth()->user()->house_number;
        $this->postcode = auth()->user()->postcode;

        return view('profile.update-address-form', [
            'user' => auth()->user(),
        ]);
    }


    public function updateAddress(): void
    {

        $this->validate([
            'city' => 'required',
            'street' => 'required',
            'house_number' => 'required',
            'postcode' => 'required',
        ]);
        $array = (array)$this;
        $array = array_slice($array, -4, 4, true);
        //array_push($array, 'id', Auth::user()->id);
        AuditTrail::logUserUpdateAddress($array);


        auth()->user()->update([
            'city' => $this->city,
            'street' => $this->street,
            'house_number' => $this->house_number,
            'postcode' => $this->postcode,
        ]);

        $this->dispatch('saved');
    }
}
