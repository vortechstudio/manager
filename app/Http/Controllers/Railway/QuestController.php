<?php

namespace App\Http\Controllers\Railway;

use App\Http\Controllers\Controller;

class QuestController extends Controller
{
    public function index()
    {
        return view('railway.quests.index');
    }
}
