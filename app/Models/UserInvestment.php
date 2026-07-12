<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UserInvestment extends Model
{
    protected $fillable = [
        'user_id', 'investment_plan_id', 'plan_name',
        'roi_percentage', 'roi_period', 'duration_days',
        'amount', 'charge', 'final_amount',
        'accrued_profit', 'profit_periods_paid', 'last_profit_at',
        'start_date', 'end_date', 'status', 'matured_at',
    ];

    protected function casts(): array
    {
        return [
            'roi_percentage'     => 'decimal:2',
            'amount'             => 'decimal:2',
            'charge'             => 'decimal:2',
            'final_amount'       => 'decimal:2',
            'accrued_profit'     => 'decimal:2',
            'start_date'         => 'date',
            'end_date'           => 'date',
            'last_profit_at'     => 'date',
            'matured_at'         => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(InvestmentPlan::class, 'investment_plan_id');
    }

    public function getDaysRemainingAttribute(): int
    {
        if ($this->status !== 'active') return 0;
        $remaining = now()->startOfDay()->diffInDays($this->end_date, false);
        return max(0, (int) $remaining);
    }

    public function getDaysElapsedAttribute(): int
    {
        return (int) $this->start_date->startOfDay()->diffInDays(now()->startOfDay());
    }

    public function getProgressPercentAttribute(): float
    {
        if ($this->duration_days === 0) return 100;
        return min(100, round(($this->days_elapsed / $this->duration_days) * 100, 1));
    }
}
