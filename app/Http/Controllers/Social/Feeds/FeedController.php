<?php

namespace App\Http\Controllers\Social\Feeds;

use App\Http\Controllers\Controller;
use App\Models\Social\Post\Post;

class FeedController extends Controller
{
    public function index()
    {
        return view('social.feeds.index');
    }

    public function show(int $id)
    {
        $feed = Post::find($id);

        return view('social.feeds.show', compact('feed'));
    }
}
