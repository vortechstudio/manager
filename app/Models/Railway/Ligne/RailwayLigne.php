<?php

namespace App\Models\Railway\Ligne;

use App\Enums\Railway\Ligne\LigneStatusEnum;
use App\Enums\Railway\Ligne\LigneTypeEnum;
use App\Models\Railway\Gare\RailwayGare;
use App\Models\Railway\Gare\RailwayHub;
use App\Models\User\Railway\UserRailwayLigne;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RailwayLigne extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $connection = 'railway';

    public $timestamps = false;

    protected $casts = [
        'status' => LigneStatusEnum::class,
        'type' => LigneTypeEnum::class,
    ];

    protected $appends = [
        'status_label',
        'icon',
        'name',
    ];

    public function start()
    {
        return $this->belongsTo(RailwayGare::class, 'start_gare_id');
    }

    public function end()
    {
        return $this->belongsTo(RailwayGare::class, 'end_gare_id');
    }

    public function hub()
    {
        return $this->belongsTo(RailwayHub::class, 'railway_hub_id');
    }

    public function stations()
    {
        return $this->hasMany(RailwayLigneStation::class);
    }

    public function userRailwayLigne()
    {
        return $this->hasMany(UserRailwayLigne::class);
    }

    public function getStatusLabelAttribute()
    {
        if ($this->active) {
            return "<i class='fa-solid fa-check-circle fs-2 text-success'></i>";
        } else {
            return "<i class='fa-solid fa-xmark-circle fs-2 text-danger'></i>";
        }
    }

    public function getIconAttribute()
    {
        if (\Storage::exists("icons/railway/transport/logo_{$this->type->value}.svg")) {
            return \Storage::url("icons/railway/transport/logo_{$this->type->value}.svg");
        } else {
            return \Storage::url("icons/railway/transport/logo_{$this->type->value}.png");
        }
    }

    public function getNameAttribute()
    {
        return $this->start->name.' <-> '.$this->end->name;
    }
}
