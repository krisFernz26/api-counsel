<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    * @return \Illuminate\Database\Eloquent\Relations\hasMany
    */
   public function appointments(): HasMany
   {
       return $this->hasMany(Appointment::class);
   }
}
