<?php

namespace App\Policies;

use App\Models\CounselorSchedule;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CounselorSchedulePolicy
{
    use HandlesAuthorization;

    public function index(User $user, CounselorSchedule $schedule)
    {
        return $user->isAdmin()
            || $user->isInstitution()
            || $user->isCounselor()
            || $user->isStudent();
    }

    public function getScheduleOfCounselor(User $user, CounselorSchedule $schedule)
    {
        return $user->isAdmin()
            || $user->isInstitution()
            || $user->isCounselor()
            || $user->isStudent();
    }

    public function show(User $user, CounselorSchedule $schedule)
    {
        return $user->isAdmin()
            || $user->isInstitution()
            || $user->isCounselor()
            || $user->isStudent();
    }

    public function delete(User $user, CounselorSchedule $schedule)
    {
        return $user->isAdmin()
            || ($user->isInstitution() && $schedule->counselor->institution_id == $user->id)
            || ($user->isCounselor() && $schedule->counselor_id == $user->id);
    }
}
