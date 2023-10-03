<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\UrlRequest;
use App\Models\Url;
use Illuminate\Database\Eloquent\Model;

class UrlController extends ApiController
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->model = new Url();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UrlRequest $request): Model
    {
        return $this->storeModel($request);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UrlRequest $request, string $id): Model
    {
        return $this->updateModel($request, $id);
    }
}
