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

    public function show(User $user, DailySchedule $dailySchedule)
    {
        return $user->isAdmin()
            || $user->isInstitution()
            || $user->isCounselor()
            || $user->isStudent();
    }

    public function getAllDailySchedulesOfCounselor(User $user, DailySchedule $dailySchedule)
    {
        return $user->isAdmin()
            || $user->isInstitution()
            || $user->isCounselor()
            || $user->isStudent();
    }

    public function update(User $user, DailySchedule $dailySchedule)
    {
        return $user->isAdmin()
            || ($user->isInstitution() && $dailySchedule->counselor->institution_id == $user->institution_id)
            || ($user->isCounselor() && $dailySchedule->counselor_id == $user->id);
    }

    public function store(User $user, DailySchedule $dailySchedule)
    {
        return $user->isAdmin()
            || ($user->isInstitution() && $dailySchedule->counselor->institution_id == $user->institution_id)
            || ($user->isCounselor() && $dailySchedule->counselor_id == $user->id);
    }

    public function delete(User $user, DailySchedule $dailySchedule)
    {
        return $user->isAdmin()
            || ($user->isInstitution() && $dailySchedule->counselor->institution_id == $user->institution_id)
            || ($user->isCounselor() && $dailySchedule->counselor_id == $user->id);
    }
}
