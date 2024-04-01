<?php

namespace App\Models\Social;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventGraphic extends Model
{
    protected function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    protected function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
