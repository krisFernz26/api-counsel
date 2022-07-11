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

    protected $with = ['media', 'institution:id,name,address'];

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
        'institution_id',
        'role_id',
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

    /**
     * Register media collections for user model
     */
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

    /**
     * Check if User is an admin
     * 
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->role_id == 1;
    }

    /**
     * Check if User is an institution
     * 
     * @return boolean
     */
    public function isInstitution()
    {
        return $this->role_id == 2;
    }

    /**
     * Check if User is a counselor
     * 
     * @return boolean
     */
    public function isCounselor()
    {
        return $this->role_id == 3;
    }

    /**
     * Check if User is a student
     * 
     * @return boolean
     */
    public function isStudent()
    {
        return $this->role_id == 4;
    }

    /**
     * Get the Role that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get all of the notes for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notes(): HasMany
    {
        switch ($this->role_id) {
            case 3:
                return $this->hasMany(Note::class, 'counselor_id', 'id');
                break;
            case 4:
                return $this->hasMany(Note::class, 'student_id', 'id');
                break;
            default:
                return $this->hasMany(Note::class, 'counselor_id', 'id');
                break;
        }
    }

    /**
     * Get all of the appointments for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appointments(): HasMany
    {
        switch ($this->role_id) {
            case 3:
                return $this->hasMany(Appointment::class, 'counselor_id', 'id');
                break;
            case 4:
                return $this->hasMany(Appointment::class, 'student_id', 'id');
                break;
            default:
                return $this->hasMany(Appointment::class, 'counselor_id', 'id');
                break;
        }
    }

    /**
     * Get all of the dailySchedules for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(DailySchedule::class);
    }
}
