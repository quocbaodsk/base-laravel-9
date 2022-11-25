<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    protected $primaryKey = "key";

    protected $keyType = "string";

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'key',
        'value',
    ];

    protected $casts = [
        'value' => 'array',
    ];

    public function getValueAttribute($value)
    {
        return json_decode($value) ?? $value;
    }
}
