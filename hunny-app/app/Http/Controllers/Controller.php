<?php

namespace App\Http\Controllers;

use illuminate\Http\Request;

abstract class Controller
{
    //
}

class DashboardController extends Controller
{

    public function index()
    {
        return view('dashboard');
    }
}
