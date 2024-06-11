<?php

namespace App\Models\Railway\Research;

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
}
