<?php

namespace App\Models\Parts;

use App\Models\Brand;
use App\Models\FormFactor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pc_case extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'pc_cases';

    protected $fillable = [
        'Name',
        'FKFormfactorId',
        'FKBrandId',
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
