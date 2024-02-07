<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\MassPrunable;

class Notification extends Model
{
    use HasFactory, MassPrunable;

    protected $fillable = [
        'subject',
        'message',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prunable(): Builder
    {
        echo "Hello World";
        return static::whereNotNull('read_at')->where('read_at', '<=', now()->subWeek());
    }
}
