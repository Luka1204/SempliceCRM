<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'amount',
        'stage',
        'expected_close_date',
        'company_id',
        'contact_id',
        'user_id'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'expected_close_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Etapas del deal
    const STAGES = [
        'prospect' => 'Prospect',
        'qualification' => 'Qualification',
        'proposal' => 'Proposal',
        'negotiation' => 'Negotiation',
        'closed_won' => 'Closed Won',
        'closed_lost' => 'Closed Lost',
    ];

    // Scopes
    public function scopeByUser($query, User $user)
    {
        return $query->where('user_id', $user->id);
    }

    public function scopeByStage($query, string $stage)
    {
        return $query->where('stage', $stage);
    }

    public function scopeOpen($query)
    {
        return $query->whereNotIn('stage', ['closed_won', 'closed_lost']);
    }

    public function scopeClosed($query)
    {
        return $query->whereIn('stage', ['closed_won', 'closed_lost']);
    }

    public function scopeUpcoming($query, int $days = 7)
    {
        return $query->where('expected_close_date', '<=', now()->addDays($days))
                    ->whereNotIn('stage', ['closed_won', 'closed_lost']);
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
    public function getStageNameAttribute(): string
    {
        return self::STAGES[$this->stage] ?? $this->stage;
    }

    public function getIsClosedAttribute(): bool
    {
        return in_array($this->stage, ['closed_won', 'closed_lost']);
    }

    public function getIsWonAttribute(): bool
    {
        return $this->stage === 'closed_won';
    }

    // Métodos de utilidad
    public function closeWon(): void
    {
        $this->update(['stage' => 'closed_won']);
    }

    public function closeLost(): void
    {
        $this->update(['stage' => 'closed_lost']);
    }
}