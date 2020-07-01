<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Exception;

abstract class ApiController extends Controller
{
    public $modelName;
    public $model;
    protected $perPage = 15;

    /**
     * ApiController constructor.
     * @throws \Exception
     * @SuppressWarnings(missingimport)
     */
    public function __construct()
    {
        if (! isset($this->modelName)) {
            throw new Exception('Model name property not set', 500);
        }

        $model = '\App\Models\\'.$this->modelName;

        $this->model = new $model;
    }

    /**
     * Display a listing of the resource.
     *
     * @return ApiCollection
     */
    public function index()
    {
        return $this->apiResponse($this->model->paginate($this->perPage));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return ApiCollection
     */
    public function store(Request $request)
    {
        $this->validateRequest($request);
        $this->model->fill($request->toArray());
        $this->model->save();
        $this->model->refresh();
        return $this->apiResponse($this->model);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return ApiCollection
     */
    public function show($id)
    {
        return $this->apiResponse($this->model->findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return ApiCollection
     */
    public function update(Request $request, $id)
    {
        $this->validateRequest($request, '');
        $this->model->findOrFail($id);
        $this->model->update($request->toArray());
        $this->model->refresh();
        return $this->apiResponse($this->model);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->model->destroy($id)) {
            return response('', 204);
        }

        abort(404, 'Resource not found');
    }

    /**
     * Send formated response for api.
     *
     * @param mixed $response
     * @return ApiCollection
     */
    protected function apiResponse($response)
    {
        if (! $response instanceof LengthAwarePaginator) {
            $response = collect($response);
        }

        return new ApiCollection($response);
    }

    /**
     * Add request validation to each child controller.
     *
     * @param Request $request
     * @param string $required
     * @return mixed
     */
    abstract protected function validateRequest(Request $request, $required = 'required:');
}
