<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;

    protected $table = 'prodi';

    protected $fillable = [
        'nama_prodi',
        'jenjang',
        'fakultas',
        'akreditasi',
        'tes_ujian',
        'tes_wawancara',
        'tes_kesehatan',
        'biaya_registrasi',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
