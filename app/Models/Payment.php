<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Monolog\Level;

class Payment extends Model
{
    protected $table = 'payments';
    protected $fillable = ['user_id', 'amount', 'level', 'status', 'reference', 'payment_method', 'payment_method_code', 'currency'];

    // User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Level
    public function level()
    {
        return $this->belongsTo(Level::class);
    }

}
