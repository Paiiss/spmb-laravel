<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exams extends Model
{
    use HasFactory;

    protected $table = 'exams';

    protected $fillable = [
        'name',
        'description',
        'duration',
        'is_active',
    ];

    public function questions()
    {
        return $this->hasMany(ExamQuestion::class, 'exam_id', 'id');
    }

    // public function histories()
    // {
    //     return $this->hasMany(ExamHistory::class, 'exam_id', 'id');
    // }

    // public function scopeActive($query)
    // {
    //     return $query->where('is_active', true);
    // }
}
