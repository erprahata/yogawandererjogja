<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class YogaClass extends Model
{
    protected $fillable = [
        'name', 
        'description',
        'type',             // Kolom baru
        'recurring_days',   // Kolom baru
        'start_time',       // Kolom baru
        'location',         // Kolom baru 
        'schedule', 
        'price', 
        'quota',
        'image'
    ];

    protected $casts = [
        'recurring_days' => 'array', // Mengubah JSON dari DB menjadi Array PHP secara otomatis
        'schedule' => 'datetime',
        'price' => 'decimal:2',
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
