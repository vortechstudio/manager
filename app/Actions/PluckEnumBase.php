<?php

namespace App\Actions;

use App\Enums\Config\ServiceStatusEnum;
use App\Enums\Config\ServiceTypeEnum;
use App\Enums\Social\ArticleTypeEnum;
use App\Enums\Social\EventStatusEnum;
use App\Enums\Social\EventTypeEnum;
use Spatie\LaravelOptions\Options;

class PluckEnumBase
{
    public function handle($enum)
    {
        return match ($enum) {
            ServiceTypeEnum::class => $this->serviceType(),
            ServiceStatusEnum::class => $this->serviceStatus(),
            ArticleTypeEnum::class => $this->articleType(),
            EventTypeEnum::class => $this->eventType(),
            EventStatusEnum::class => $this->eventStatus(),
        };
    }

    private function serviceType()
    {
        return collect([
            [
                'name' => 'JEUX',
                'value' => 'jeux',
            ],
            [
                'name' => 'PLATEFORME',
                'value' => 'plateforme',
            ],
        ])->pluck('name', 'value');
    }

    private function serviceStatus()
    {
        return collect([
            [
                'name' => 'IDEA',
                'value' => 'idéa',
            ],
            [
                'name' => 'DEVELOP',
                'value' => 'develop',
            ],
            [
                'name' => 'PRODUCTION',
                'value' => 'production',
            ],
        ])->pluck('name', 'value');
    }

    private function eventType()
    {
        return collect([
            [
                'name' => 'POLL',
                'value' => 'poll',
            ],
            [
                'name' => 'GRAPHIC',
                'value' => 'graphic',
            ],
        ])->pluck('name', 'value');
    }

    private function eventStatus()
    {
        return Options::forEnum(EventTypeEnum::class)->toArray();
    }
}
