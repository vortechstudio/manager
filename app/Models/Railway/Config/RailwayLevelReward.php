<?php

namespace App\Models\Railway\Config;

use App\Enums\Railway\Config\LevelRewardTypeEnum;
use Illuminate\Database\Eloquent\Model;

class RailwayLevelReward extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    protected $casts = [
        'type' => LevelRewardTypeEnum::class,
    ];
}
