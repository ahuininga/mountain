<?php

namespace App\Models;

use App\Traits\MultiTenantable;

class App extends BaseModel
{
    use MultiTenantable;

    /**
     * @var array<string>
     */
    protected $fillable = [
        'name', 'user_id', 'active',
    ];

    /**
     * Get the user that owns this app.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the urls belonging to this app.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function urls()
    {
        return $this->hasMany('App\Models\Url');
    }
}
