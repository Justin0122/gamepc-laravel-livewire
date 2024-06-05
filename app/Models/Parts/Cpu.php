<?php

namespace App\Models\Parts;

use App\Models\Brand;
use App\Models\Generation;
use App\Models\Socket;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cpu extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'Name',
        'FKBrandId',
        'FKGenerationId',
        'FKSocketId',
        'Cores',
        'Threads',
        'BaseClock',
        'BoostClock',
        'Price',
        'Stock'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'FKBrandId');
    }

    public function generation()
    {
        return $this->belongsTo(Generation::class, 'FKGenerationId');
    }

    public function socket()
    {
        return $this->belongsTo(Socket::class, 'FKSocketId');
    }

}
