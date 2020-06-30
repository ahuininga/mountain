<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait MultiTenantable
{
    protected static function bootMultitenantable()
    {
        if (auth()->check()) {
            static::creating(function ($model) {
                $model->user_id = auth()->id();
            });

            static::addGlobalScope('user_id', function (Builder $builder) {
                $builder->where('user_id', auth()->id());
            });
        }
    }
}
