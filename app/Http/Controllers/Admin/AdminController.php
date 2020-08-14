<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class AdminController extends Controller
{
    public function __construct()
    {
        // get all data from menu.json file
        $menuJson = json_decode(file_get_contents(base_path('resources/json/adminMenu.json')));

        // Share all menuData to all the views
        View::share('menuData',[$menuJson]);
    }
}
