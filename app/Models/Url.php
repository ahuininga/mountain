<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Url extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'app_id',
        'url',
        'main',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        parent::booted();
        static::saved(function ($url) {
            //if this url is the main url, all other urls for the same app are not main urls.
            if ($url->main) {
                $allAppUrls = new Url();
                $allAppUrls->where([
                    ['app_id', '=', $url->app_id],
                    ['id', '!=', $url->id],
                ])->update(['main' => 0]);
                $url->refresh();
            }
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function app()
    {
        return $this->belongsTo(App::class);
    }

    public function parent()
    {
        return $this->belongsTo($this, 'app_id');
    }

    public function children()
    {
        return $this->hasMany($this, 'app_id');
    }

    public function getMainUrl(string $url)
    {
        $mainUrl = $this->removeProtocol(env('APP_URL'));

        $result = $this->where('url', $url)
            ->with(['parent' => function ($q) {
                $q->where('main', '=', 1);
            }])->first();

        if (! empty($result)) {
            $result = $result->toArray();
            //parent url is always the main url
            $mainUrl = $result['parent']['url'];
            Session::put('currentApp', $result['parent']['app_id']);
        }

        return $mainUrl;
    }

    private function removeProtocol(string $url)
    {
        $url = parse_url($url);

        return $url['host'];
    }
}
