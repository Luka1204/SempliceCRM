<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
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
        'notification_preferences',
        'email_notifications',
        'activity_reminders',
        'reminder_hours_before',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'notification_preferences' => 'array',
        'email_notifications' => 'boolean',
        'activity_reminders' => 'boolean',
    ];

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

      /**
     * Get activities that need reminders
     */
    public function activitiesNeedingReminder()
    {
        $reminderTime = now()->addHours($this->reminder_hours_before);
        
        return $this->activities()
            ->where('status', 'scheduled')
            ->where('scheduled_at', '>=', now())
            ->where('scheduled_at', '<=', $reminderTime)
            ->with(['company', 'contact'])
            ->get();
    }

    /**
     * Check if user wants activity reminders
     */
    public function wantsActivityReminders(): bool
    {
        return $this->activity_reminders && $this->email_notifications;
    }

    /**
     * Get today's scheduled activities
     */
    public function todaysActivities()
    {
        return $this->activities()
            ->where('status', 'scheduled')
            ->whereDate('scheduled_at', today())
            ->with(['company', 'contact'])
            ->orderBy('scheduled_at')
            ->get();
    }
}
