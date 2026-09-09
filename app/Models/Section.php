<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'title',
        'order',
    ];

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class, 'section_id');
    }
}
