<?php

namespace App\Models\Parts;

use App\Models\Brand;
use App\Models\Socket;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Case_cooler extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'Name',
        'FKBrandId',
        'Price',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'FKBrandId');
    }

    public function addCase($request)
    {
        $casecooler = new Case_cooler();
        $casecooler->Name = $request->Name;
        $casecooler->FKBrandId = $request->FKBrandId;
        $casecooler->Price = $request->Price;
        $casecooler->save();
    }
}

