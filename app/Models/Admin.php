<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class Admin extends User
{
    protected $table = 'users';

    protected static function booted(): void
    {
        parent::booted();

        static::addGlobalScope('admin', function (Builder $builder) {
            $builder->where('is_admin', true);
        });

        static::creating(function (Admin $admin) {
            $admin->is_admin = true;
        });
    }
}
