<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\Controller;
use App\Models\Social\Cercle;

class CercleController extends Controller
{
    public function index()
    {
        return view('social.cercle.index');
    }

    public function show(int $id)
    {
        $cercle = Cercle::with('events', 'articles', 'wiki_categories', 'service')->find($id);
        return view('social.cercle.show', compact('cercle'));
    }
}
