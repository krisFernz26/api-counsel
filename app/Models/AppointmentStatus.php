<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Appointment;

class AppointmentStatus extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'title',
        'description'
    ];

   /**
    * Get the appointment that owns the AppointmentStatus
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function appointment(): BelongsTo
   {
       return $this->belongsTo(Appointment::class);
   }
}
