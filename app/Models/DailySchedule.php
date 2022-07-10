<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailySchedule extends Model
{
    use HasFactory;

    protected $with = ['counselorSchedule'];

    protected $fillable = [
        'counselor_schedule_id',
        'date',
        'day',
        'start_time',
        'end_time'
    ];

    /**
     * Get the counselorSchedule that owns the DailySchedule
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function counselorSchedule(): BelongsTo
    {
        return $this->belongsTo(CounselorSchedule::class);
    }
}
