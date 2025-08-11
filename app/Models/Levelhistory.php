<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Levelhistory extends Model
{
    protected $table = 'level_history';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected $fillable = [
        'user_id',
        'from_level',
        'to_level',
        'upgraded_at',
    ];
}
