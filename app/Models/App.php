<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Scopes\CurrentUserScope;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class App extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'user_id',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($app) {
            $app->user_id = Auth::id();
        });
        static::addGlobalScope(new CurrentUserScope());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function urls()
    {
        return $this->hasMany(Url::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function settings()
    {
        return $this->hasMany(Setting::class);
    }

    public function modules()
    {
        return $this->belongsToMany(Module::class)->withPivot(['status', 'created_at', 'updated_at']);
    }

    public function allModules(string $id)
    {
        $appSettings = $this->with('modules')->select()->findOrFail($id)->toArray();
        $modules = collect(Module::select('*', 'default as status')->get())->keyBy('id');
        $appModules = collect($appSettings['modules'])->keyBy('id');

        $appModules = $appModules->map(function ($item) {
            $item['status'] = $item['pivot']['status'];
            $item['created_at'] = $item['pivot']['created_at'];
            $item['updated_at'] = $item['pivot']['updated_at'];
            unset($item['pivot']);

            return $item;
        });

        $appSettings['modules'] = $modules->merge($appModules)->values();

        return $appSettings;
    }
}
