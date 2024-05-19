<?php

namespace App\Http\Controllers\Railway;

use App\Http\Controllers\Controller;
use App\Models\Railway\Core\Achievement;

class AchievementController extends Controller
{
    public function index()
    {
        return view('railway.achievement.index');
    }

    public function show(int $id)
    {
        $achievement = Achievement::find($id);

        return view('railway.achievement.show', [
            'achievement' => $achievement,
        ]);
    }
}
