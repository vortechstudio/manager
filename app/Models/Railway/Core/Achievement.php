<?php

namespace App\Models\Railway\Core;

use App\Enums\Railway\Core\AchievementLevelEnum;
use App\Enums\Railway\Core\AchievementSectorEnum;
use App\Models\User\Railway\UserRailwayAchievement;
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
    protected $appends = [
        'icon',
        'icon_sector',
    ];

    public function rewards()
    {
        return $this->belongsToMany(AchieveReward::class, 'achievements_rewards', 'achievement_id', 'reward_id');
    }

    public function getIconAttribute()
    {
        return \Storage::url('icons/railway/success/'.$this->level->value.'.png');
    }

    public function getIconSectorAttribute()
    {
        return \Storage::url('icons/railway/success/'.$this->sector->value.'.png');
    }
}
