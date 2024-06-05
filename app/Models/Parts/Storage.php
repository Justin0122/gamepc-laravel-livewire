<?php

namespace App\Models\Parts;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Storage extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'Name',
        'FKBrandId',
        'StorageCapacity',
        'StorageSpeed',
        'Price',
    ];
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'FKBrandId');
    }
}
