<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditTrail extends Model
{
    use HasFactory;

    protected $fillable = [
        'Name',
        'action',
        'FKUserId',
        'partId',
        'table_name',
        'field_name',
        'old_value',
        'new_value'

    ];
}
