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
        return $user->isAdmin(); 
    }

    public function getAllAppointmentsOfUser(User $user, Appointment $appointment)
    {
        return $user->isAdmin()
            || ($user->isInstitution() && ($appointment->student->institution_id == $user->institution_id || $appointment->counselor->institution_id == $user->institution_id));
    }

    public function show(User $user, Appointment $appointment)
    {
        return $user->isAdmin()
            || ($user->isInstitution() && ($appointment->student->institution_id == $user->institution_id || $appointment->counselor->institution_id == $user->institution_id))
            || ($user->isCounselor() && $appointment->counselor_id == $user->id)
            || ($user->isStudent() && $appointment->student_id == $user->id); 
    }

    public function store(User $user, Appointment $appointment)
    {
        return $user->isAdmin()
            || $user->isCounselor(); 
    }

    public function update(User $user, Appointment $appointment)
    {
        return $user->isAdmin()
            || ($user->isInstitution() && $appointment->counselor->institution_id == $user->institution_id) 
            || ($user->isCounselor() && $appointment->counselor_id == $user->id); 
    }

    public function delete(User $user, Appointment $appointment)
    {
        return $user->isAdmin()
            || ($user->isInstitution() && $appointment->counselor->institution_id == $user->institution_id) 
            || ($user->isCounselor() && $appointment->counselor_id == $user->id); 
    }

    public function start(User $user, Appointment $appointment)
    {
        return $user->isAdmin()
            || ($user->isCounselor() && $appointment->counselor_id == $user->id); 
    }

    public function complete(User $user, Appointment $appointment)
    {
        return $user->isAdmin()
            || ($user->isCounselor() && $appointment->counselor_id == $user->id); 
    }

    public function cancel(User $user, Appointment $appointment)
    {
        return $user->isAdmin()
            || ($user->isInstitution() && ($appointment->student->institution_id == $user->institution_id || $appointment->counselor->institution_id == $user->institution_id))
            || ($user->isCounselor() && $appointment->counselor_id == $user->id) 
            || ($user->isStudent() && $appointment->student_id == $user->id); 
    }
}
