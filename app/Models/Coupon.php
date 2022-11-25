<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'remaining',
        'status',
        'service',
        'expired_at',
    ];

    protected $casts = [
        'remaining' => 'integer',
        'value' => 'integer',
    ];
}
