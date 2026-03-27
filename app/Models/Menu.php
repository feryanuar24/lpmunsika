<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'parent_id',
        'name',
        'url',
        'icon',
        'permission',
        'description',
    ];

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }
}
