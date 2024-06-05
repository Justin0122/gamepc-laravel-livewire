<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormFactor extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'formfactors';

    protected $fillable = [
        'Name',
        'FormFactorWidth',
        'FormFactorDepth',
    ];
}
