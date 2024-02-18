<?php

namespace App\Models\Config;

use App\Enums\Config\ServiceStatusEnum;
use App\Enums\Config\ServiceTypeEnum;
use App\Models\Support\Tickets\Ticket;
use App\Models\Support\Tickets\TicketCategory;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pharaonic\Laravel\Pages\HasPages;

class Service extends Model
{
    use HasPages, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'type' => ServiceTypeEnum::class,
        'status' => ServiceStatusEnum::class,
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function versions(): HasMany
    {
        return $this->hasMany(ServiceVersion::class);
    }

    public function ticket_categories()
    {
        return $this->hasMany(TicketCategory::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
