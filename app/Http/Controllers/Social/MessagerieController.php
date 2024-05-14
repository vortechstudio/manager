<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\Controller;

class MessagerieController extends Controller
{
    public function index()
    {
        return view('social.messagerie.index');
    }
}
