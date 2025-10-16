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
        'user_id'
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
            return secure_asset('storage/' . $this->image);
        }
        // Return a placeholder image if no image is set
        return 'https://via.placeholder.com/400x200/1f2937/ffffff?text=Blog+Image';
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
