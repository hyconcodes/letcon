<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'status',
        'bank_name',
        'bank_account_name',
        'bank_account_number',
        'comment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function wallet()
    // {
    //     return $this->hasOne(Wallet::class);
    // }
}
