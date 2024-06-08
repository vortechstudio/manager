<?php

namespace App\Http\Controllers\Railway;

use App\Http\Controllers\Controller;
use App\Models\Railway\Core\Achievement;
use App\Models\Railway\Core\RailwayAchievement;

class AchievementController extends Controller
{
    public function index()
    {
        return view('railway.achievement.index');
    }

    public function show(int $id)
    {
        $achievement = RailwayAchievement::find($id);

        return view('railway.achievement.show', [
            'achievement' => $achievement,
        ]);
    }
}
