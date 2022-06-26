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
        return $user->hasRole('admin') 
            || ($user->hasRole('counselor') && $appointment->counselor_id === $user->id) 
            || ($user->hasRole('student') && $appointment->student_id === $user->id);
    }
}
