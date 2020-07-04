<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

class HomepageController extends FrontendController
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('frontend.homepage.index');
    }
}
