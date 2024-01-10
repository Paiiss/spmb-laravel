<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wave extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'gelombang',
        'tahun_akademik',
        'awal_daftar',
        'akhir_daftar',
        'tes_tulis',
        'tes_kesehatan',
        'wawancara',
        'active'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public static function getActiveData()
    {
        return static::where('active', true) ?: null;
    }
}
