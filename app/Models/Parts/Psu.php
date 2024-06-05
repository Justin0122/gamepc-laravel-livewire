<?php

namespace App\Models\Parts;

use App\Models\Brand;
use App\Models\FormFactor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Psu extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'Name',
        'FKBrandId',
        'Wattage',
        'Price',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'FKBrandId');
    }

    public function formfactor()
    {
        return $this->belongsTo(FormFactor::class, 'FKFormFactorId');
    }
}
