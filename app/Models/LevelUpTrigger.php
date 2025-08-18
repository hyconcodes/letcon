<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevelUpTrigger extends Model
{
    protected $table = 'level_up_triggers';
    protected $fillable = [
        'user_id',
        'triggered_by',
        'level'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function triggeredBy()
    {
        return $this->belongsTo(User::class, 'triggered_by');
    }
}
