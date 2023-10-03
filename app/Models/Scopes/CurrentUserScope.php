<?php

declare(strict_types=1);

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class CurrentUserScope implements Scope
{
    public function __construct(private string $field = 'user_id')
    {
        //
    }

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  string  $field
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        if (Auth::hasUser()) {
            $builder->where($this->field, Auth::id());
        }
    }
}
