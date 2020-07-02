<?php

namespace App\Models;

class Url extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'url', 'app_id',
    ];

    /**
     * Get the app that owns this url.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function app()
    {
        return $this->belongsTo('App\Models\App');
    }
}
