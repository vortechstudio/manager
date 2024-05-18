<?php

namespace App\Http\Controllers\Railway;

use App\Http\Controllers\Controller;

class AchievementController extends Controller
{
    public function index()
    {
        return view('railway.achievement.index');
    }
}
