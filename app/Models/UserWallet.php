<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserWallet extends Model
{
    protected $fillable = ['user_id', 'withdrawal_method_id', 'wallet_address'];

    public function method()
    {
        return $this->belongsTo(WithdrawalMethod::class, 'withdrawal_method_id');
    }
}
