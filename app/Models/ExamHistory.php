<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamHistory extends Model
{
    use HasFactory;

    protected $table = 'exam_histories';

    protected $fillable = [
        'exam_id',
        'user_id',
        'score',
        'duration',
        'is_active',
        'is_finished',
        'is_submitted',
        'started_at',
        'finished_at',
        'order_questions',
        'answers'
    ];

    public function exam()
    {
        return $this->belongsTo(Exams::class, 'exam_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
