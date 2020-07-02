<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

class UsersController extends ApiController
{
    /**
     * UsersController constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->modelName = 'User';
        parent::__construct();
    }

    /**
     * @param Request $request
     * @param string $required
     * @return array|void
     */
    protected function validateRequest(Request $request, $required = 'required:')
    {
        $request->validate([
            'firstname' => $required . 'string:max:255',
            'lastname' => $required . 'string:max:255',
            'email' => $required . 'email:unique:users',
            'password' => $required . 'string:max:255',
        ]);
    }
}
