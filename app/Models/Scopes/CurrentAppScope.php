<?php

declare(strict_types=1);

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CurrentAppScope implements Scope
{
    public function __construct(public string $field = 'app_id')
    {
        //
    }

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  string  $field
     * @return void
     *
     * @throws Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     */
    public function apply(Builder $builder, Model $model)
    {
        if (! Session::get('currentApp')) {
            //should not happen
            throw new BadRequestHttpException(__('CANT_DETECT_CURRENT_APP'));
        }

        $builder->where($this->field, Session::get('currentApp'));
    }
}
