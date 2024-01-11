<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $table = 'forms';

    // protected $fillable = ['wave_id', 'option_id', 'option_2_id'];
    protected $guarded = [];
    protected $fillable = array('*');

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
