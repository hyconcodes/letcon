<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    protected $table = 'referrals';
    protected $fillable = ['referrer_id', 'referred_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
