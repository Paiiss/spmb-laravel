<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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
        $today = Carbon::now()->toDateString();
        return static::where('active', true)->whereDate('awal_daftar', '<=', $today)
            ->whereDate('akhir_daftar', '>=', $today)->get();
    }

    public static function getActiveDataById($id)
    {
        return static::where('active', true)->where('id', $id)->first() ?: null;
    }
}
