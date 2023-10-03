<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserController extends ApiController
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->model = new User();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request): Model
    {
        $user = $this->storeModel($request);

        //create default api token
        $token = $user->createToken(__('general.default_api_token'));
        $user->token = $token->plainTextToken;

        return $user;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id): Model
    {
        return $this->updateModel($request, $id);
    }
}
