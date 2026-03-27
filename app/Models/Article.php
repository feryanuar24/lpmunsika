<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'content',
        'thumbnail',
        'is_active',
        'is_pinned',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_pinned' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'article_tag', 'article_id', 'tag_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
