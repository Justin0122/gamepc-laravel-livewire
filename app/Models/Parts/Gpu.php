<?php

namespace App\Models\Parts;

use App\Models\Brand;
use App\Models\MemoryType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gpu extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'Name',
        'FKBrandId',
        'Memory',
        'FKMemoryTypeId',
        'MemoryInterface',
        'MemoryBandWidth',
        'BaseClock',
        'BoostClock',
        'Price',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'FKBrandId');
    }

    public function memorytype(): BelongsTo
    {
        return $this->belongsTo(MemoryType::class, 'FKMemoryTypeId');
    }

}
