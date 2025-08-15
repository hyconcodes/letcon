<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $table = 'wallets';
    protected $fillable = ['user_id', 'balance', 'earned_balance', 'total_withdraw', 'pending_withdraw', 'rejected_withdraw'];

    // User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
