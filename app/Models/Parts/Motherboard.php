<?php

namespace App\Models\Parts;

use App\Models\Brand;
use App\Models\FormFactor;
use App\Models\MemoryType;
use App\Models\Socket;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Motherboard extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'Name',
        'FKSocketId',
        'FKBrandId',
        'MemoryType',
        'FKFormFactorId',
        'MemoryCapacity',
        'USBPorts',
        'PCIeSlots',
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

    public function socket()
    {
        return $this->belongsTo(Socket::class, 'FKSocketId');
    }

    public function memorytype()
    {
        return $this->belongsTo(MemoryType::class, 'FKMemoryTypeId');
    }
}
