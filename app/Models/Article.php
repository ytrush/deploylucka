<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Parsedown;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'featured_image',
        'author_id',
        'published_at',
        'is_published',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'boolean',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Article $article) {
            if (empty($article->author_id) && Auth::check()) {
                $article->author_id = Auth::id();
            }
            if (empty($article->slug) && $article->title) {
                $article->slug = \Illuminate\Support\Str::slug($article->title);
            }
            if ($article->is_published && empty($article->published_at)) {
                $article->published_at = now();
            }
        });

        static::updating(function (Article $article) {
            if (empty($article->slug) && $article->title) {
                $article->slug = \Illuminate\Support\Str::slug($article->title);
            }
        });
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function getContentHtmlAttribute(): string
    {
        $parsedown = new Parsedown();
        // Parsedown needs blank lines between paragraphs
        // Split by double newlines first to preserve existing paragraph breaks
        $paragraphs = preg_split('/\n\n+/', $this->content);
        
        // Parse each paragraph and join with double newlines
        $parsed = array_map(function($para) use ($parsedown) {
            return trim($para);
        }, $paragraphs);
        
        $content = implode("\n\n", $parsed);
        return $parsedown->text($content);
    }
}