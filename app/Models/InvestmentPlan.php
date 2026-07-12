<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvestmentPlan extends Model
{
    protected $fillable = [
        'name', 'roi_percentage', 'roi_period', 'duration_days',
        'min_amount', 'max_amount', 'charge_type', 'charge_amount',
        'is_active', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'roi_percentage' => 'decimal:2',
            'min_amount'     => 'decimal:2',
            'max_amount'     => 'decimal:2',
            'charge_amount'  => 'decimal:2',
            'is_active'      => 'boolean',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function calculateCharge(float $amount): float
    {
        if ($this->charge_amount <= 0) return 0;

        return $this->charge_type === 'percentage'
            ? round($amount * $this->charge_amount / 100, 2)
            : (float) $this->charge_amount;
    }

    public function investments()
    {
        return $this->hasMany(UserInvestment::class);
    }
}
