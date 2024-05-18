<?php

namespace App\Models\Railway\Core;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    public $timestamps = false;
    protected $guarded = [];
    protected $connection = 'railway';

    public function rewards()
    {
        return $this->belongsToMany(AchieveReward::class, 'achievements_rewards', 'achievement_id', 'reward_id');
    }
}
