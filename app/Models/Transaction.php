<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'FKUserId',
        'FKMyPcId',
        'total_price',
        'status',
        'payment_method',
        'shipped_at',
        'delivered_at',
        'cancelled_at',
        'refunded_at',
    ];
}
