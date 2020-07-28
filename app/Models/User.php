<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Class User
 * @package App\Models
 * @property string $email
 */

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<string>
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

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

    /**
     * Generate an uuid instead of autoincrement id.
     */
    protected static function boot()
    {
        parent::boot();
        //generate an uuid on new models
        self::creating(function ($model) {
            $model->id = Str::uuid()->toString();
            $model->password = Hash::make($model->password);
        });
    }

    /**
     * Get the apps this user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function apps()
    {
        return $this->hasMany('App\Models\App');
    }
}
