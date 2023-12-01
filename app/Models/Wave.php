<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wave extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'active'
    ];

    public static function getActiveData()
    {
        return static::where('active', true) ?: null;
    }
}
