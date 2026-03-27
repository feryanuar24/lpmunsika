<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description'
    ];

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_tag', 'tag_id', 'article_id');
    }
}
