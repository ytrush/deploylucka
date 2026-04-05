<?php

namespace App\Models;

use App\Models\Progress;
use App\Models\Question;
use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'section_id',
        'title',
        'content',
        'video_url',
        'duration',
        'order',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function progresses(): HasMany
    {
        return $this->hasMany(Progress::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
}
