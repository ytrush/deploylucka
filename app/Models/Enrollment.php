<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enrollment extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'enrolled_at',
        'status',
        'notes',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'enrolled_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public const STATUS_ACTIVE = 'active';
    public const STATUS_PAUSED = 'paused';
    public const STATUS_COMPLETED = 'completed';

    public static function getStatusOptions(): array
    {
        return [
            self::STATUS_ACTIVE => 'Aktif',
            self::STATUS_PAUSED => 'Ditangguhkan',
            self::STATUS_COMPLETED => 'Selesai',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Scope to get active enrollments
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope to get paused enrollments
     */
    public function scopePaused($query)
    {
        return $query->where('status', self::STATUS_PAUSED);
    }

    /**
     * Scope to get completed enrollments
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    /**
     * Mark enrollment as paused
     */
    public function pause(string $reason = null): bool
    {
        $this->status = self::STATUS_PAUSED;
        if ($reason) {
            $this->notes = $reason;
        }
        return $this->save();
    }

    /**
     * Resume paused enrollment
     */
    public function resume(): bool
    {
        if ($this->status !== self::STATUS_PAUSED) {
            return false;
        }
        $this->status = self::STATUS_ACTIVE;
        $this->notes = null;
        return $this->save();
    }

    /**
     * Mark enrollment as completed
     */
    public function markCompleted(): bool
    {
        $this->status = self::STATUS_COMPLETED;
        $this->completed_at = now();
        return $this->save();
    }

    /**
     * Check if enrollment is active
     */
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * Check if enrollment is paused
     */
    public function isPaused(): bool
    {
        return $this->status === self::STATUS_PAUSED;
    }

    /**
     * Check if enrollment is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }
}
