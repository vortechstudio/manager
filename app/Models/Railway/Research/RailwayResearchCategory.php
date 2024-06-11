<?php

namespace App\Models\Railway\Research;

use Illuminate\Database\Eloquent\Model;

class RailwayResearchCategory extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    protected $connection = 'railway';

    public function researches()
    {
        $this->hasMany(RailwayResearches::class);
    }
}
