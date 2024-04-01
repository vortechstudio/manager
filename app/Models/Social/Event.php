<?php

namespace App\Models\Social;

use App\Enums\Social\EventStatusEnum;
use App\Enums\Social\EventTypeEnum;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Pharaonic\Laravel\Taggable\Traits\Taggable;

class Event extends Model
{
    use Taggable;

    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'status' => EventStatusEnum::class,
        'type_event' => EventTypeEnum::class,
        'published_at' => 'datetime',
    ];

    protected $appends = [
        'type_label',
        'status_label',
    ];

    public function cercles()
    {
        return $this->belongsToMany(Cercle::class, 'event_cercle', 'event_id', 'cercle_id');
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'user_event', 'event_id', 'user_id');
    }

    public function poll()
    {
        return $this->hasOne(Poll::class);
    }

    public function getTypeLabelAttribute()
    {
        return match ($this->type_event) {
            EventTypeEnum::POLL => '<span class="badge badge-primary"><i class="fa-solid fa-poll text-white me-2"></i> Sondage</span>',
            EventTypeEnum::GRAPHIC => '<span class="badge badge-warning"><i class="fa-solid fa-image text-white me-2"></i> Graphique</span>',
        };
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            EventStatusEnum::DRAFT => '<span class="badge badge-secondary"><i class="fa-solid fa-pencil text-white me-2"></i> Brouillon</span>',
            EventStatusEnum::PROGRESS => '<span class="badge badge-success"><i class="fa-solid fa-exchange-alt text-white me-2"></i> En cours...</span>',
            EventStatusEnum::SUBMITTING => '<span class="badge badge-primary"><i class="fa-solid fa-envelope text-white me-2"></i> Soumission en cours...</span>',
            EventStatusEnum::EVALUATION => '<span class="badge badge-info"><i class="fa-solid fa-envelope text-white me-2"></i> Evaluation en cours...</span>',
            EventStatusEnum::CLOSED => '<span class="badge badge-danger"><i class="fa-solid fa-check-circle text-white me-2"></i> Terminer</span>',
            EventStatusEnum::PUBLISHED => '<span class="badge badge-warning"><i class="fa-solid fa-network-wired text-white me-2"></i> Publier</span>',
        };
    }

    public static function getImage(int $event_id, string $type): string
    {
        $type = match ($type) {
            'icon' => 'icon',
            'header' => 'header',
            'default' => 'default',
        };

        if (\Storage::exists('events/'.$event_id.'/'.$type.'.webp')) {
            return \Storage::url('events/'.$event_id.'/'.$type.'.webp');
        } else {
            return \Storage::url('events/'.$type.'_default.png');
        }
    }
}
