<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'position',
        'age',
        'nationality',
        'age_group',
        'profile_photo',
        'status',
        'consent_form_path',
        'child_name',
        'relationship_to_player',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function progress()
    {
        return $this->hasMany(\App\Models\PlayerProgress::class);
    }

    public function trainingSchedules()
    {
        return $this->belongsToMany(\App\Models\TrainingSchedule::class, 'training_schedule_player')
            ->withPivot('attendance')
            ->withTimestamps();
    }

    public function inboxMessages()
    {
        return $this->hasMany(\App\Models\PlayerMessage::class, 'to_user_id')->latest();
    }

    public function sentMessages()
    {
        return $this->hasMany(\App\Models\PlayerMessage::class, 'from_user_id')->latest();
    }

    public function ratings()
    {
        return $this->hasMany(\App\Models\PlayerRating::class, 'player_id')->latest();
    }

    public function latestRating()
    {
        return $this->hasOne(\App\Models\PlayerRating::class, 'player_id')->latest();
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
