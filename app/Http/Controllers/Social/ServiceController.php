<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    public function index()
    {
        return view('social.services.index');
    }
}
