<?php

namespace App\Models;

class Role extends BaseModel
{
    protected $fillable = ['name'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
