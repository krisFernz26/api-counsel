<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'appointment_status_id',
        'student_id',
        'counselor_id',
        'link',
        'date',
        'start_time',
        'end_time'
    ];

    /**
     * Get the status associated with the Appointment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function currentStatus()
    {
        return $this->hasOne(AppointmentStatus::class)->latestOfMany();
    }
}
