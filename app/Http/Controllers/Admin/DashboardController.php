<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class DashboardController extends AdminController
{
    /**
     * @return string
     */
    public function index()
    {
        return view('admin.dashboard.index');
    }
}
