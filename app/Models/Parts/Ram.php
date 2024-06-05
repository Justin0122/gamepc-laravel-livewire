<?php

namespace App\Models\Parts;

use App\Models\Brand;
use App\Models\MemoryType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ram extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'Name',
        'FKBrandId',
        'Capacity',
        'FKMemoryTypeId',
        'Price',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'FKBrandId');
    }

    public function memoryType(): BelongsTo
    {
        return $this->belongsTo(MemoryType::class, 'FKMemoryTypeId');
    }

    public function addRam($request)
    {
        $ram = new Ram();
        $ram->Name = $request->Name;
        $ram->FKBrandId = $request->FKBrandId;
        $ram->Capacity = $request->Capacity;
        $ram->Speed = $request->Speed;
        $ram->Price = $request->Price;
        $ram->save();
    }
}
