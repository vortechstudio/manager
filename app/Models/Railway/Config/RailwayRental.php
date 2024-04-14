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
        if (\Storage::exists('logos/rentals/'.\Str::lower($this->name).'.webp')) {
            return \Storage::url('logos/rentals/'.\Str::lower($this->name).'.webp');
        } else {
            return \Storage::url('logos/rentals/default.png');
        }
    }
}
