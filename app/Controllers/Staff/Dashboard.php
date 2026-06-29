<?php

namespace App\Controllers\Staff;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        return view('staff/dashboard');
    }
}