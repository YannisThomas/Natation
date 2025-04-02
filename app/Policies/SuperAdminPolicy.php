<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SuperAdminPolicy
{
    use HandlesAuthorization;

    /**
     * Vérifie si l'utilisateur est un SuperAdmin
     */
    public function isSuperAdmin(User $user)
    {
        return $user->role->name === 'superadmin';
    }
}
