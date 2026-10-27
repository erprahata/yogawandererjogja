<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = [
        'user_id', 'yoga_class_id', 'transaction_code',
        'status', 'payment_method', 'qr_code_path', 'is_attended',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function yogaClass(): BelongsTo
    {
        return $this->belongsTo(YogaClass::class);
    }
}
