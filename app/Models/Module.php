<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;
    use HasUuids;

    public function apps()
    {
        return $this->belongsToMany(App::class)->withPivot(['status', 'created_at', 'updated_at']);
    }
}
