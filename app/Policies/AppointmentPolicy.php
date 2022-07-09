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
        dd($user);
        return $user->isAdmin() 
            || ($user->isCounselor() && $appointment->counselor_id === $user->id) 
            || ($user->isStudent() && $appointment->student_id === $user->id);
    }
}
