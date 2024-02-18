<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Form extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'forms';

    // protected $fillable = ['wave_id', 'option_id', 'option_2_id'];
    protected $guarded = [];
    protected $fillable = array('*');

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wave()
    {
        return $this->belongsTo(Wave::class);
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'option_id', 'id');
    }

    public function health()
    {
        return $this->belongsTo(Health::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('ktp')->singleFile();
        $this->addMediaCollection('foto')->singleFile();
        $this->addMediaCollection('ijazah')->singleFile();
        $this->addMediaCollection('transkrip_nilai')->singleFile();
    }
}
