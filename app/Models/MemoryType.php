<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemoryType extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'memorytypes';

    protected $fillable = [
        'Name',
        'MemoryTypeSpeed',
    ];

}
