<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interviews extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'no_exam',
        'interview_date',
        'note',
        'verificator_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getInterviews()
    {
        return $this->where('user_id', auth()->user()->id)->get();
    }

}
