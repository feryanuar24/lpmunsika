<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laratrust\Contracts\LaratrustUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\HasRolesAndPermissions;

class User extends Authenticatable implements MustVerifyEmail, LaratrustUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes, HasRolesAndPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the articles for the user.
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    /**
     * Get the comments for the user.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the chats for the user.
     */
    public function chats()
    {
        return $this->hasMany(Chat::class);
    }
}
