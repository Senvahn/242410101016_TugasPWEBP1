<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            return view('landing.admin-dashboard', compact('user'));
        } else {
            return view('landing.customer-dashboard', compact('user'));
        }
    }
}
