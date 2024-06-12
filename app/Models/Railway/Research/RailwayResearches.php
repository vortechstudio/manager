<?php

namespace App\Models\Railway\Research;

use App\Services\RailwayService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RailwayResearches extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    protected $connection = 'railway';

    protected $casts = [
        'benefits' => "array"
    ];

    protected $appends = [
        'image'
    ];

    public function railwayResearchCategory(): BelongsTo
    {
        return $this->belongsTo(RailwayResearchCategory::class);
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function childrens()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function getImageAttribute()
    {
        $service = (new RailwayService())->getRailwayService();
        return \Cache::remember('getImageAttribute:'.$this->id, 1440, function () use ($service) {
            return \Storage::exists("services/{$service->id}/game/icons/research/".$this->id.'.png') ? \Storage::url("services/{$service->id}/game/icons/research/".$this->id.'.png') : \Storage::url("services/{$service->id}/game/icons/research/default.png");
        });
    }

    public function hasChildrens()
    {
        return $this->childrens->count() > 0;
    }
}
