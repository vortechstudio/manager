<?php

namespace App\Models\Railway\Config;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RailwayRental extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'uuid' => 'string',
        'type' => 'array',
    ];

    protected $appends = [
        'image',
    ];

    public function getImageAttribute()
    {
        if (\Storage::exists('logos/rentals/'.\Str::lower($this->name).'.png')) {
            return asset('storage/logos/rentals/'.\Str::lower($this->name).'.png');
        } else {
            return asset('storage/logos/rentals/default.png');
        }
    }
}
