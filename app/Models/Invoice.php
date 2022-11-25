<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'prefix',
        'amount',
        'type',
        'status',
        'channel',
        'user_id',
        'username',
        'content',
        'user_note',
        'expired_at'
    ];
}
