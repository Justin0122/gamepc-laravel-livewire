<?php
namespace Database\Seeders;

use App\Models\Brand;
use App\Models\FormFactor;
use App\Models\Generation;
use App\Models\MemoryType;
use App\Models\Socket;

class InsertData
{
    public static function generations(): void
    {
        $generations = [
            '1st Gen',
            '2nd Gen',
            '3rd Gen',
            '4th Gen',
            '5th Gen',
            '6th Gen',
            '7th Gen',
            '8th Gen',
            '9th Gen',
            '10th Gen',
            '11th Gen',
            '12th Gen',
            '13th Gen',
            '14th Gen',
            'Ryzen 1000',
            'Ryzen 2000',
            'Ryzen 3000',
            'Ryzen 4000',
            'Ryzen 5000',
            'Ryzen 6000',
            'Ryzen 7000'
        ];

        foreach ($generations as $generation) {
            Generation::create([
                'Name' => $generation,
            ]);
        }
    }
    public static function brands(): void
    {
        $brands = [
            'AMD',
            'Intel',
            'Nvidia',
            'Asus',
            'Gigabyte',
            'MSI',
            'Corsair',
            'Kingston',
            'Crucial',
            'Samsung',
            'Seagate',
            'Western Digital',
            'Cooler Master',
        ];
        foreach ($brands as $brand) {
            Brand::create([
                'Name' => $brand,
            ]);
        }
    }

    public static function sockets(): void
    {
        $sockets = [
            'AM4',
            'LGA 1151',
            'LGA 1200',
            'LGA 2066',
            'TR4',
            'sTRX4',
            'LGA 1150',
            'LGA 1155',
            'LGA 1156',
            'LGA 2011',
            'LGA 2011-3',
            'LGA 2066',
            'LGA 3647',
            'LGA 775',
            'FM2+',
            'FM2',
            'FM1',
            'AM3+',
            'AM3',
            'AM2+',
            'AM2',
            'AM1',
            'SP3',
            'SP3r2',
            'sWRX8',
            'sWRX8r2',
            'sTR4',
            'sTRX4',
            'sWRX8',
            'sWRX8r2',
            'sTR4',
            'sTRX4',
            'sWRX8',
            'sWRX8r2',
            'sTR4',
            'sTRX4',
            'sWRX8',
            'sWRX8r2',
            'sTR4',
            'sTRX4',
            'sWRX8',
            'sWRX8r2',
            'sTR4',
            'sTRX4',
            'sWRX8',
            'sWRX8r2',
            'sTR4',
            'sTRX4',
            'sWRX8',
            'sWRX8r2',
            'sTR4',
            'sTRX4',
            'sWRX8',
            'sWRX8r2',
            'sTR4',
            'sTRX4',
            'sWRX8',
            'sWRX8r2',
            'sTR4',
            'sTRX4',
            'sWRX8',
            'sWRX8r2',
        ];
        foreach ($sockets as $socket) {
            Socket::create([
                'Name' => $socket,
            ]);
        }
    }

    public static function memoryTypes(): void
    {
        $memoryTypes = [
            'DDR',
            'DDR2',
            'DDR3',
            'DDR4',
            'DDR5',
            'DDR6',
        ];
        foreach ($memoryTypes as $memoryType) {
            MemoryType::create([
                'Name' => $memoryType,
                'MemoryTypeSpeed' => rand(1000, 5000),
            ]);
        }
    }

    public static function formfactors(): void
    {
        $formfactors = [
            'ATX',
            'EATX',
            'Micro ATX',
            'Mini ITX',
            'XL-ATX',
            'SFX',
            'SFX-L',
            'Flex ATX',
            'Mini DTX',
            'Thin Mini ITX',
            'Micro BTX',
            'Mini BTX',
            'Nano BTX',
            'Pico BTX',
            'WTX',
            'SSI CEB',
            'SSI EEB',
            'SSI MEB',
            'SSI TEB',
            'SSI TEB2',
            'SSI TFP',
            'SSI THIN EEB',
            'SSI THIN EEB2',
            ];

        foreach ($formfactors as $formfactor) {
            FormFactor::create([
                'Name' => $formfactor,
                'FormFactorWidth' => '0',
                'FormFactorDepth' => '0',
            ]);
        }
    }

}
