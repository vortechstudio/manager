<?php

namespace App\Models\Railway\Core;

use App\Enums\Railway\Core\AchievementLevelEnum;
use App\Enums\Railway\Core\AchievementSectorEnum;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    public $timestamps = false;
    protected $guarded = [];
    protected $connection = 'railway';
    protected $casts = [
        'sector' => AchievementSectorEnum::class,
        'level' => AchievementLevelEnum::class,
    ];

    public function rewards()
    {
        return $this->belongsToMany(AchieveReward::class, 'achievements_rewards', 'achievement_id', 'reward_id');
    }
}
