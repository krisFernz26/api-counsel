<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CounselorSchedule extends Model
{
    use HasFactory;

    protected $with = ['counselor:id,institution_id,last_name,first_name', 'dailySchedules'];

    protected $fillable = [
        'counselor_id'
    ];

    protected $hidden = [
        'counselor_id'
    ];

    /**
     * Get the counselor that owns the CounselorSchedule
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function counselor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'counselor_id', 'id');
    }

    /**
     * Get all of the dailySchedules for the CounselorSchedule
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dailySchedules(): HasMany
    {
        return $this->hasMany(DailySchedule::class);
    }
}
