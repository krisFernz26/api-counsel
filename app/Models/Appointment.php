<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    protected $with = ['currentStatus:id,title', 'student:id,institution_id,last_name,first_name,username', 'counselor:id,institution_id,last_name,first_name,username'];

    protected $fillable = [
        'appointment_status_id',
        'student_id',
        'counselor_id',
        'link',
        'date',
        'start_time',
        'end_time'
    ];

    protected $hidden = [
        'student_id',
        'counselor_id',
        'appointment_status_id',
        'deleted_at'
    ];

    /**
     * Get the status associated with the Appointment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currentStatus()
    {
        return $this->belongsTo(AppointmentStatus::class);
    }

    /**
     * Get the student that owns the Appointment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id', 'id');
    }

    /**
     * Get the counselor that owns the Appointment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function counselor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'counselor_id', 'id');
    }
}
