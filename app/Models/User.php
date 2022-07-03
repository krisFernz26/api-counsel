<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia;

    protected $with = ['media', 'institution'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'institution_id',
        'username',
        'birthdate',
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile_pic')->singleFile();
    }

    /**
     * Get the institution that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function checkRole($roleId)
    {
        return in_array($this->role_id, $roleId);
    }

    /**
     * Get all of the notes for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function counselorNotes(): HasMany
    {
        return $this->hasMany(Note::class, 'counselor_id', 'id');
    }

    /**
     * Get all of the studentNotes for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function studentNotes(): HasMany
    {
        return $this->hasMany(Note::class, 'student_id', 'id');
    }

    /**
     * Get all of the appointments for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function studentAppointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'student_id', 'id');
    }

    /**
     * Get all of the counselorAppointments for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function counselorAppointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'counselor_id', 'id');
    }
}
