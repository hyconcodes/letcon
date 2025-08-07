<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    protected $table = 'referrals';
    protected $fillable = ['referrer_id', 'referred_id'];

    // Upline (Referrer)
    // public function referrer()
    // {
    //     return $this->belongsTo(User::class, 'referrer_id');
    // }

    // // Downline (Referred)
    // public function referred()
    // {
    //     return $this->belongsTo(User::class, 'referred_id');
    // }

    // // Get all downlines (referred users) of a referrer
    // public function downlines()
    // {
    //     return $this->hasMany(Referral::class, 'referrer_id');
    // }

    // // Get all uplines (referrers) of a referred user
    // public function uplines()
    // {
    //     return $this->hasMany(Referral::class, 'referred_id');
    // }

    // // Get all downlines (referred users) of a referred user
    // public function downlinesReferred()
    // {
    //     return $this->hasMany(Referral::class, 'referred_id');
    // }

    // // Get all uplines (referrers) of a referrer
    // public function uplinesReferred()
    // {
    //     return $this->hasMany(Referral::class, 'referrer_id');
    // }
}
