<?php

namespace App\Http\Controllers\Social\Feeds;

use App\Http\Controllers\Controller;

class FeedController extends Controller
{
    public function index()
    {
        return view('social.feeds.index');
    }
}
