<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function index()
    {
        return view('social.pages.index');
    }
}
