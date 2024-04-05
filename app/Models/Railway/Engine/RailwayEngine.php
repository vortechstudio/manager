<?php

namespace App\Models\Railway\Engine;

use App\Enums\Railway\Engine\RailwayEngineEnergyEnum;
use App\Enums\Railway\Engine\RailwayEngineStatusEnum;
use App\Enums\Railway\Engine\RailwayEngineTrainEnum;
use App\Enums\Railway\Engine\RailwayEngineTransportEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RailwayEngine extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'uuid' => 'string',
        'type_transport' => RailwayEngineTransportEnum::class,
        'type_train' => RailwayEngineTrainEnum::class,
        'type_energy' => RailwayEngineEnergyEnum::class,
        'status' => RailwayEngineStatusEnum::class,
    ];

    public function shop()
    {
        return $this->hasOne(RailwayEngineShop::class);
    }

    public function price()
    {
        return $this->hasOne(RailwayEnginePrice::class);
    }

    public function technical()
    {
        return $this->hasOne(RailwayEngineTechnical::class);
    }

    public function getFirstImage($engine_id)
    {
        $engine = self::find($engine_id);

        if ($engine->type_train == RailwayEngineTrainEnum::AUTO) {
            return \Storage::url('engines/automotrice/'.\Str::slug($engine->name).'-0.gif');
        } else {
            return \Storage::url('engines/'.$engine->type_train.'/'.\Str::slug($engine->name).'.gif');
        }
    }
}
