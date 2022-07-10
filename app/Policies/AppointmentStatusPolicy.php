<?php

namespace App\Policies;

use App\Models\AppointmentStatus;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AppointmentStatusPolicy
{
    use HandlesAuthorization;

    /**
     * Update a status 
     * 
     * @param User $user
     * @param AppointmentStatus $status
     */
    public function update(User $user, AppointmentStatus $status)
    {
        return $user->isAdmin();
    }

    /**
     * Delete a status 
     * 
     * @param User $user
     * @param AppointmentStatus $status
     */
    public function delete(User $user, AppointmentStatus $status)
    {
        return $user->isAdmin();
    }
}
