<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AppointmentPolicy
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

    public function index(User $user, Appointment $appointment)
    {
        return $user->checkRole(0) 
            || ($user->checkRole(2) && $appointment->counselor_id === $user->id) 
            || ($user->checkRole(3) && $appointment->student_id === $user->id);
    }
}
