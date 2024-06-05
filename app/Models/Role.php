<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class Role extends Model
{
    use HasFactory;

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function givePermissionTo($permission)
    {
        $this->permissions()->save(
            Permission::whereName($permission)->firstOrFail()
        );
    }

    public function removePermissionTo($permission)
    {
        $this->permissions()->detach(
            Permission::whereName($permission)->firstOrFail()
        );
    }

}
