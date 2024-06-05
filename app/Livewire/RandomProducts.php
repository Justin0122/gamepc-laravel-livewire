<?php

namespace App\Livewire;

use Livewire\Component;

class RandomProducts extends Component
{
    public array $randomProducts = [];

    public array $tabellen = [
        'cpu',
        'gpu',
        'case_cooler',
        'Pc_case',
        'motherboard',
        'psu',
        'ram',
        'storage',
        'cpu_cooler'
    ];

    public function mount()
    {

    }

    public function render()
    {
        $this->randomProducts = $this->getRandomProducts(1);

        return view('livewire.random-products', [
            'randomProducts' => $this->randomProducts,
        ]);
    }

    public function getRandomProducts($amount)
    {
        foreach ($this->tabellen as $tabel) {
            $modelClass = 'App\\Models\\Parts\\' . ucfirst($tabel);

            $query = $modelClass::query();

            $randomProducts = $query->inRandomOrder()->limit($amount)->where('deleted_at', null)->get();
            foreach ($randomProducts as $product) {
                $this->randomProducts[] = $product;
            }
        }
        return $this->randomProducts;

    }
}
