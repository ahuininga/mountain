<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

class AppsController extends ApiController
{
    /**
     * UsersController constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->modelName = 'App';
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
            'name' => $required.'max:255',
            'active' => $required.'boolean',
        ]);
    }
}
