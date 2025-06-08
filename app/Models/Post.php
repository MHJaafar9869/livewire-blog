<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function scopePublished(Builder $query)
    {
        return $query->whereNotNull('published_at')
            ->where('published_at', '<=', Carbon::now());
    }

    public function scopeFeatured(Builder $query)
    {
        return $query->where('is_featured', '=', true)
            ->published()
            ->latest('published_at');
    }

    public function scopeSearch(Builder $query, string $searchTerm)
    {
        if (trim($searchTerm) === '') {
            return $query;
        }

        return $query->where('title', 'LIKE', "%{$searchTerm}%");
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getExcerpt()
    {
        $excerpt = strip_tags($this->body);
        $excerpt = str_replace(["\r", "\n"], ' ', $excerpt);
        $excerpt = preg_replace('/\s+/', ' ', $excerpt); // Remove extra spaces
        $excerpt = Str::limit(rtrim($excerpt, ' .'), 150, '...'); // Limit to 150 characters

        return $excerpt;
    }

    public function getReadingTime()
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $readingTime = ceil($wordCount / 200); // Assuming average reading speed of 200 words per minute

        return $readingTime || 1;
    }
}
