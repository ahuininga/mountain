<?php

namespace App\Models;

use App\Traits\MultiTenantable;

class App extends BaseModel
{
    use MultiTenantable;

    protected $fillable = [
        'name', 'user_id', 'active',
    ];

    /**
     * Get the user that owns this app.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the urls belonging to this app.
     */
    public function urls()
    {
        return $this->hasMany('App\Models\Url');
    }
}
