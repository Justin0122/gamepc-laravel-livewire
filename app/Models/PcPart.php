<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PcPart extends Model
{
    public string $partType;
    public $part;

    public function __construct($partType)
    {
        $this->partType = $partType;
    }

    public function getImages($parts){

        foreach ($parts as $part) {
            $this->Image($part);
        }
        return $parts;
    }

    public static function findPartName($type, $id)
    {
        // Mapping of type names to lowercase equivalents
        $typeMap = [
            'Pc_case' => 'pc_case',
            'CpuCooler' => 'cpu_cooler',
            'CaseCooler' => 'case_cooler',
        ];
        $type = $typeMap[$type] ?? strtolower($type);

        $modelClass = 'App\\Models\\Parts\\' . ucfirst($type);

        return $modelClass::query()
            ->select($type . 's.Name')
            ->where($type . 's.id', '=', $id)
            ->first();
    }

    /**
     * @param $part
     * @return void
     */
    public function Image($part): void
    {
        $folderPath = public_path('storage/parts/' . $this->partType . '/' . $part->id);

        $files = glob($folderPath . '/*');

        if (!empty($files)) {
            $filename = basename($files[0]);
            $part->image = asset('storage/parts/' . $this->partType . '/' . $part->id . '/' . $filename);
        } else {
            if (!file_exists($folderPath)) {
                Storage::makeDirectory('public/parts/' . $this->partType . '/' . $part->id);
            }
            $part->image = '';
        }
    }

    public function removeStock($partId, $partType): void
    {
        $sql = "UPDATE " . $partType . "s SET Stock = Stock - 1 WHERE Id = " . $partId;

        $this->sql($sql, $partType, $partId);
    }

    private function sql($sql, $partType, $partId)
    {
        $connection = app('db')->connection();
        $modelClass = 'App\\Models\\Parts\\' . ucfirst($partType);
        $part = $modelClass::withTrashed()->find($partId);
        $connection->statement($sql);


        return $part;
    }


    public function getPrice($partId, $partType) {
        $sql = 'SELECT price FROM ' . $partType . 's WHERE id = ' . $partId . '';
        $array = $this->sql($sql, $partType, $partId);
        $price = $array->getAttributes();
        return $price['Price'];
    }

}
