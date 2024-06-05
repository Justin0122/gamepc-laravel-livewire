<?php

namespace App\Actions\Jetstream;

use App\AuditTrail;
use App\Models\User;
use Laravel\Jetstream\Contracts\DeletesUsers;

class DeleteUser implements DeletesUsers
{
    /**
     * Delete the given user.
     */
    public function delete(User $user): void
    {
        AuditTrail::logUserDelete();

        $user->delete();
    }
}
