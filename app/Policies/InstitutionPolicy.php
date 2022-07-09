<?php

namespace App\Policies;

use App\Models\Institution;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InstitutionPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function store(User $user, Institution $institution)
    {
        return $user->isAdmin() || ($user->isInstitution() && $user->institution_id === $institution->id);
    }

    public function update(User $user, Institution $institution)
    {
        return $user->isAdmin() || ($user->isInstitution() && $user->institution_id === $institution->id);
    }

    public function delete(User $user, Institution $institution)
    {
        return $user->isAdmin() || ($user->isInstitution() && $user->institution_id === $institution->id);
    }
}
