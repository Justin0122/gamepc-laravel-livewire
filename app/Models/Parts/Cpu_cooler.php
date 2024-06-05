<?php

namespace App\Models\Parts;

use App\Models\Brand;
use App\Models\Generation;
use App\Models\Socket;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cpu_cooler extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'Name',
        'Price',
        'FKBrandId',
        'FKSocketId',
        'Generation',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'FKBrandId');
    }

    public function socket()
    {
        return $this->belongsTo(Socket::class, 'FKSocketId');
    }

    public function generation()
    {
        return $this->belongsTo(Generation::class, 'FKGenerationId');
    }
}
