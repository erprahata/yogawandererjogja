<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens; 
use Illuminate\Database\Eloquent\Factories\HasFactory; // 1. Tambahkan impor ini

class User extends Authenticatable
{
    use HasApiTokens, HasFactory; // 2. Tambahkan HasFactory di sini

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