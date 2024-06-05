<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;

/**
 * @method static where(string $string, $id)
 */
class MyPc extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'MyPcId';

    public static function getSchema(): array
    {
        $fields = array_map(
            fn ($value) => ucfirst(strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', substr($value, 2, -2)))),
            array_filter(Schema::getColumnListing('my_pcs'), fn ($value) => str_starts_with($value, 'FK'))
        );
        array_shift($fields);
        // to avoid conflict with php keyword
        return array_map(fn ($value) => $value == 'Case' ? 'Pc_case' : $value, $fields);
    }

    public function getUserId(): BelongsTo
    {
        return $this->belongsTo(FormFactor::class, 'FKUserId');
    }
    public function getCpuId(): BelongsTo
    {
        return $this->belongsTo(FormFactor::class, 'FKCpuId');
    }

    public function getCpuCoolerId(): BelongsTo
    {
        return $this->belongsTo(FormFactor::class, 'FKCpuCoolerId');
    }

    public function getMotherboardId(): BelongsTo
    {
        return $this->belongsTo(FormFactor::class, 'FKMotherboardId');
    }
    public function getRamId(): BelongsTo
    {
        return $this->belongsTo(FormFactor::class, 'FKRamId');
    }
    public function getStorageId(): BelongsTo
    {
        return $this->belongsTo(FormFactor::class, 'FKStorageId');
    }
    public function getGpuId(): BelongsTo
    {
        return $this->belongsTo(FormFactor::class, 'FKGpuId');
    }

    public function getPsuId(): BelongsTo
    {
        return $this->belongsTo(FormFactor::class, 'FKPsuId');
    }
    public function getCaseId(): BelongsTo
    {
        return $this->belongsTo(FormFactor::class, 'FKCaseId');
    }
}
