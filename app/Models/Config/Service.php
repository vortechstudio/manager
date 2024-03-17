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

    protected $appends = [
        'type_label',
        'status_label',
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

    public function getTypeLabelAttribute()
    {
        return match ($this->type) {
            ServiceTypeEnum::PLATEFORME => '<span class="badge badge-primary"><i class="fa-solid fa-cubes text-white me-2"></i> Plateforme</span>',
            ServiceTypeEnum::JEUX => '<span class="badge badge-warning"><i class="fa-solid fa-gamepad text-white me-2"></i> Jeux</span>',
        };
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            ServiceStatusEnum::IDEA => '<span class="badge badge-warning"><i class="fa-solid fa-lightbulb text-white me-2"></i> Idée</span>',
            ServiceStatusEnum::DEVELOP => '<span class="badge badge-primary"><i class="fa-solid fa-code text-white me-2"></i> Développement</span>',
            ServiceStatusEnum::PRODUCTION => '<span class="badge badge-success"><i class="fa-solid fa-boxes-stacked text-white me-2"></i> Production</span>',
        };
    }

    public static function getImage(int $cercle_id, string $type)
    {
        $type = match ($type) {
            'icon' => 'icon',
            'header' => 'header',
            'default' => 'default',
        };

        if (\Storage::exists('cercles/'.$cercle_id.'/'.$type.'.webp')) {
            return \Storage::url('cercles/'.$cercle_id.'/'.$type.'.webp');
        } else {
            return \Storage::url('cercles/'.$type.'_default.png');
        }
    }
}
