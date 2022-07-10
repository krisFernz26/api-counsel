<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailySchedule extends Model
{
    use HasFactory;

    protected $with = ['counselor'];

    public $timestamps = false;

    protected $fillable = [
        'counselor_id',
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
    public function counselor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'counselor_id', 'id');
    }
}
