<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamQuestion extends Model
{
    use HasFactory;

    protected $table = 'exam_questions';

    protected $fillable = [
        'exam_id',
        'question',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'option_e',
        'answer'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function exams()
    {
        return $this->belongsTo(Exams::class, 'exam_id', 'id');
    }
}
