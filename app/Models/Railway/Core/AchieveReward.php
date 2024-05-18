<?php

namespace App\Models\Railway\Core;

use Illuminate\Database\Eloquent\Model;

class AchieveReward extends Model
{
    public $timestamps = false;
    protected $guarded = [];
    protected $connection = 'railway';

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'achievements_rewards', 'reward_id', 'achievement_id');
    }
}
