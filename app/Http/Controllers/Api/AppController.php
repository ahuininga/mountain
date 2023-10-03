<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\AppRequest;
use App\Models\App;
use Illuminate\Database\Eloquent\Model;

class AppController extends ApiController
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->model = new App();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Model|array
    {
        return $this->model->allModules($id);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AppRequest $request): Model
    {
        return $this->storeModel($request);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AppRequest $request, string $id): Model
    {
        return $this->updateModel($request, $id);
    }
}
