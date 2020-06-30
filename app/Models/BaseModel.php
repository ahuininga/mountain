<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    /**
     * Disable auto-incrementing the primary key field for this model.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Override the primary key type.
     *
     * @var string
     */
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();
        //generate an uuid on new models
        self::creating(function ($model) {
            $model->id = Str::uuid()->toString();
        });
    }
}
