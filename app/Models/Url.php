<?php

namespace App\Models;

class Url extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url', 'app_id',
    ];

    /**
     * Get the app that owns this url.
     */
    public function app()
    {
        return $this->belongsTo('App\Models\App');
    }
}
