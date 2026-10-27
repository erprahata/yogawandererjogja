<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens; // 1. Import class Sanctum ini

class User extends Authenticatable
{
    use HasApiTokens; // 2. Panggil trait di dalam class

    protected $fillable = [
        'name', 'email', 'phone_number', 'password', 'role',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
