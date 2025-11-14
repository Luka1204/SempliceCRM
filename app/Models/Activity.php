<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Activity extends Model
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $fillable = [
        'type',
        'title',
        'description',
        'scheduled_at',
        'completed_at',
        'status',
        'company_id',
        'contact_id',
        'user_id'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Tipos de actividad
    const TYPES = [
        'call' => 'Phone Call',
        'meeting' => 'Meeting',
        'email' => 'Email',
        'task' => 'Task',
        'note' => 'Note',
    ];

    // Estados
    const STATUSES = [
        'scheduled' => 'Scheduled',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
    ];

    // Scopes
    public function scopeByUser($query, User $user)
    {
        return $query->where('user_id', $user->id);
    }

    public function scopeUpcoming($query, int $days = 7)
    {
        return $query->where('scheduled_at', '<=', now()->addDays($days))
                    ->where('status', 'scheduled')
                    ->orderBy('scheduled_at');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    // Relaciones
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    // Accesores
    public function getTypeNameAttribute(): string
    {
        return self::TYPES[$this->type] ?? $this->type;
    }

    public function getStatusNameAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    public function getIsOverdueAttribute(): bool
    {
        return $this->scheduled_at && $this->scheduled_at->isPast() && $this->status === 'scheduled';
    }

    // Métodos de utilidad
    public function markAsCompleted(): bool
    {
        return $this->update([
            'status' => 'completed',
            'completed_at' => now()
        ]);
    }

    public function markAsCancelled(): bool
    {
        return $this->update(['status' => 'cancelled']);
    }

    public function reschedule(\DateTime $newDate): bool
    {
        return $this->update([
            'scheduled_at' => $newDate,
            'status' => 'scheduled'
        ]);
    }

     

    public function routeNotificationForMail($notification): array|string
    {
        return $this->user->email;
    }


    public function preferredChannels(): array
    {
        return ['mail', 'database'];
    }
}