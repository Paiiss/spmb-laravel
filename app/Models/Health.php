<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Health extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'medical_check_up';

    protected $fillable = [
        'user_id',
        'height',
        'weight',
        'blood_type',
        'blood_pressure',
        'blood_sugar',
        'is_smoking',
        'color_blind',
        'is_disability',
        'note',
        'status',
        'admin_note'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')
            ->singleFile();
    }
}
