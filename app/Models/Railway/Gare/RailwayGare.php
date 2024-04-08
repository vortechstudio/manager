<?php

namespace App\Models\Railway\Gare;

use App\Enums\Railway\Gare\GareTypeEnum;
use App\Models\Railway\Ligne\RailwayLigneStation;
use Illuminate\Database\Eloquent\Model;

class RailwayGare extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'type' => GareTypeEnum::class,
    ];

    protected $appends = [
        'is_hub',
        'type_gare_string',
    ];

    public function weather()
    {
        return $this->hasOne(RailwayGareWeather::class);
    }

    public function hub()
    {
        return $this->hasOne(RailwayHub::class);
    }

    public function stations()
    {
        return $this->hasMany(RailwayLigneStation::class);
    }

    public function getTypeGareStringAttribute(): string
    {
        return match ($this->type->value) {
            'halte' => 'Halte',
            'small' => 'Petite Gare',
            'medium' => 'Moyenne Gare',
            'large' => 'Grande Gare',
            'terminus' => 'Terminus'
        };
    }

    public function getIsHubAttribute(): bool
    {
        return $this->hub()->count() != 0;
    }

    public function formatIsHub()
    {
        if ($this->getIsHubAttribute()) {
            return "<i class='fa-solid fa-check-circle fs-1 text-success'></i>";
        } else {
            return "<i class='fa-solid fa-xmark-circle fs-1 text-danger'></i>";
        }
    }
}
