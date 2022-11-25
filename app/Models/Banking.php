<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banking extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'bank_name',
        'account_number',
        'account_name'
    ];

}
