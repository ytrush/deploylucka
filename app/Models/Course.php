<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Enrollment;
use App\Models\Materi;
use App\Models\MateriCompletion;
use App\Models\Question;
use App\Models\Section;
use App\Models\Instructor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'instructor_id',
        'category_id',
        'title',
        'description',
        'image',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(Instructor::class, 'instructor_id');
    }

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class);
    }

    public function materis(): HasMany
    {
        return $this->hasMany(Materi::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function enrolledUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'enrollments', 'course_id', 'user_id')
            ->withTimestamps()
            ->withPivot('enrolled_at');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id')->latest();
    }

    public function isEnrolledBy(User $user): bool
    {
        return $this->enrolledUsers()->where('user_id', $user->id)->exists();
    }

    /**
     * Calculate course progress percentage for the current user
     */
    public function getProgressPercentage(): int
    {
        $user = Auth::user();
        if (!$user) {
            return 0;
        }

        // Get total materis in this course
        $totalMateris = $this->materis()->count();
        if ($totalMateris === 0) {
            return 0;
        }

        $materiIds = $this->materis()->pluck('id')->all();
        if (empty($materiIds)) {
            return 0;
        }

        $completedMateris = MateriCompletion::query()
            ->where('user_id', $user->id)
            ->whereIn('materi_id', $materiIds)
            ->count();

        return (int) round($completedMateris / $totalMateris * 100);
    }
}
