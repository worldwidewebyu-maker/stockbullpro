<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class Customer extends User
{
    protected $table = 'users';

    protected static function booted(): void
    {
        parent::booted();

        static::addGlobalScope('customer', function (Builder $builder) {
            $builder->where('is_admin', false);
        });
    }
}
