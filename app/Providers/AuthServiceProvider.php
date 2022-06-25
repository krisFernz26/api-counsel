<?php

namespace App\Providers;

use App\Models\Appointment;
use App\Models\AppointmentStatus;
use App\Models\CounselorSchedule;
use App\Models\Institution;
use App\Models\Note;
use App\Models\User;
use App\Policies\AppointmentPolicy;
use App\Policies\AppointmentStatusPolicy;
use App\Policies\CounselorSchedulePolicy;
use App\Policies\InstitutionPolicy;
use App\Policies\NotePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Institution::class => InstitutionPolicy::class,
        Note::class => NotePolicy::class,
        Appointment::class => AppointmentPolicy::class,
        AppointmentStatus::class => AppointmentStatusPolicy::class,
        CounselorSchedule::class => CounselorSchedulePolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
