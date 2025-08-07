<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'fee',
        'status',
        'payment_method',
        'payment_details',
        'transaction_id',
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
