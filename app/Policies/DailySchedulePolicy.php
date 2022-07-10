<?php

namespace App\Policies;

use App\Models\DailySchedule;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DailySchedulePolicy
{
    use HandlesAuthorization;

    public function index(User $user, DailySchedule $dailySchedule)
    {
        return $user->isAdmin()
            || $user->isInstitution()
            || $user->isCounselor()
            || $user->isStudent();
    }

    public function store(User $user, DailySchedule $dailySchedule)
    {
        return $user->isAdmin()
            || ($user->isInstitution() && $dailySchedule->counselor->institution_id == $user->id)
            || $user->isCounselor();
    }
}
