<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevelSupporter extends Model
{
    protected $fillable = [
        'user_id',
        'supporter_id',
        'level',
        'assigned_at',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function supporter()
    {
        return $this->belongsTo(User::class, 'supporter_id');
    }
}
