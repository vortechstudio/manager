<?php

namespace App\Models\Railway\Config;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RailwayLevel extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    protected function railwayLevelReward(): BelongsTo
    {
        return $this->belongsTo(RailwayLevelReward::class);
    }
}
