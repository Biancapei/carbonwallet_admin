<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'content',
        'image',
        'slug',
        'is_published',
        'user_id',
        'category',
        'blog_status',
        'meta_title',
        'meta_description',
        'meta_keywords'
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($blog) {
            if (empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return app()->environment('production') ?
                secure_asset('storage/' . $this->image) :
                asset('storage/' . $this->image);
        }
        // Return a placeholder image if no image is set - use HTTPS
        return 'https://picsum.photos/400/200?random=' . $this->id;
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
