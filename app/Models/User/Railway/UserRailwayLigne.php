<?php

namespace App\Models\User\Railway;

use App\Models\Railway\Ligne\RailwayLigne;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRailwayLigne extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    protected $casts = [
        'date_achat' => 'timestamp',
    ];

    public function userRailwayHub(): BelongsTo
    {
        return $this->belongsTo(UserRailwayHub::class, 'user_railway_hub_id');
    }

    public function railwayLigne(): BelongsTo
    {
        return $this->belongsTo(RailwayLigne::class, 'railway_ligne_id');
    }

    public function userRailwayEngine(): BelongsTo
    {
        return $this->belongsTo(UserRailwayEngine::class, 'user_railway_engine_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
