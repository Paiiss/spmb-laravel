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
        'allowed',
        'shuffle_question',
        'shuffle_answer',
        'show_result',
        'access_start_time',
        'access_end_time',
        'is_active',
    ];

    public function questions()
    {
        return $this->hasMany(ExamQuestion::class, 'exam_id', 'id');
    }

    public static function activeExamSelect()
    {
        return static::select('id', 'name')->where('is_active', true)->get()->map(function ($exam) {
            return [
                'value' => $exam->id,
                'label' => $exam->name,
            ];
        });
    }

    public function canStartExams()
    {
        $now = date('H:i:s');
        $startTime = date('H:i:s', strtotime($this->attributes['access_start_time']));
        $endTime = date('H:i:s', strtotime($this->attributes['access_end_time']));
        // now >= startTime && now <= endTime
        return $now >= $startTime && $now <= $endTime;
    }

    public function histories()
    {
        return $this->hasMany(ExamHistory::class, 'exam_id', 'id');
    }

    public function getHistoryByUser($user_id)
    {
        return $this->histories()->where('user_id', $user_id)->first();
    }

    public function getHistoryByUserAndExam($user_id, $exam_id)
    {
        return $this->histories()->where('user_id', $user_id)->where('exam_id', $exam_id)->first();
    }
}
