<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'github_id',
        'github_token',
        'github_refresh_token',
        'github_token_expires_at',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'github_token_expires_at' => 'datetime',
    ];
}
