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

    // bagiamana bikin function validasi untuk mengecek wave yang aktif dengan id
    public static function getActiveDataById($id)
    {
        // return static::where('active', true, 'id', $id)->first() ?: null;

        return static::where('active', true)->where('id', $id)->first() ?: null;
    }
}
