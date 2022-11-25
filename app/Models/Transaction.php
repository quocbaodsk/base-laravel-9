<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'prefix',
        'amount',
        'type',
        'descr',
        'sys_note',
        'extras',
        'balanceBefore',
        'balanceAfter',
        'status',
        'user_id',
        'username'
    ];

    protected $casts = [
        'amount' => 'integer',
        'balanceBefore' => 'integer',
        'balanceAfter' => 'integer',
    ];

    protected $hidden = [
        'extras',
        'sys_note'
    ];
}
