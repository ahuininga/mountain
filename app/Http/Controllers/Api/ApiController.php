<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ApiController extends Controller
{
    protected Model $model;

    /**
     * Display a listing of the resource.
     */
    public function index(): LengthAwarePaginator
    {
        return $this->model->paginate();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeModel(Request $request): Model
    {
        $this->model->fill($request->validated());
        $this->model->save();

        return $this->model;
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id uuid of the resource
     */
    public function show(string $id): Model|array
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  string  $id uuid of the resource
     */
    public function updateModel(Request $request, string $id): Model
    {
        $model = $this->model->findOrFail($id);
        $model->fill($request->validated());
        $model->save();

        return $model;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id uuid of the resource
     * @return array;
     */
    public function destroy(string $id): array
    {
        if ($this->model->destroy($id)) {
            return [];
        }
        abort(404);
    }
}
