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
        'ujian',
        'tes_wawancara',
        'tes_kesehatan',
        'biaya_registrasi',
        'nilai_dibawah',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function getProdi()
    {
        return $this->hasMany(Form::class);
    }

    public static function getProdiById($id)
    {
        return static::where('id', $id)->first() ?: null;
    }

}
