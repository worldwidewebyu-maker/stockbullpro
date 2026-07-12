<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepositMethod extends Model
{
    protected $fillable = [
        'name', 'wallet_address', 'qr_code', 'network_type',
        'min_amount', 'max_amount', 'charge_type', 'charge_amount',
        'is_active', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active'     => 'boolean',
            'min_amount'    => 'decimal:2',
            'max_amount'    => 'decimal:2',
            'charge_amount' => 'decimal:2',
        ];
    }

    public function logs()
    {
        return $this->hasMany(DepositLog::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function calculateCharge(float $amount): float
    {
        if ($this->charge_type === 'percentage') {
            return round($amount * ($this->charge_amount / 100), 2);
        }
        return (float) $this->charge_amount;
    }

    public function getQrCodeUrlAttribute(): ?string
    {
        return $this->qr_code ? asset('storage/' . $this->qr_code) : null;
    }
}
