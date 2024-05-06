<?php

return [
    'name' => 'LaravelPWA',
    'manifest' => [
        'name' => env('APP_NAME', 'My PWA App'),
        'short_name' => 'Vmanager',
        'start_url' => '/',
        'background_color' => '#4B2FB3',
        'theme_color' => '#918FDA',
        'display' => 'standalone',
        'orientation' => 'any',
        'status_bar' => 'white',
        'icons' => [
            '72x72' => [
                'path' => config('filesystems.disks.vortech.url').('pwa/icons/icon-72x72.png'),
                'purpose' => 'any',
            ],
            '96x96' => [
                'path' => config('filesystems.disks.vortech.url').('pwa/icons/icon-96x96.png'),
                'purpose' => 'any',
            ],
            '128x128' => [
                'path' => config('filesystems.disks.vortech.url').('pwa/icons/icon-128x128.png'),
                'purpose' => 'any',
            ],
            '144x144' => [
                'path' => config('filesystems.disks.vortech.url').('pwa/icons/icon-144x144.png'),
                'purpose' => 'any',
            ],
            '152x152' => [
                'path' => config('filesystems.disks.vortech.url').('pwa/icons/icon-152x152.png'),
                'purpose' => 'any',
            ],
            '192x192' => [
                'path' => config('filesystems.disks.vortech.url').('pwa/icons/icon-192x192.png'),
                'purpose' => 'any',
            ],
            '384x384' => [
                'path' => config('filesystems.disks.vortech.url').('pwa/icons/icon-384x384.png'),
                'purpose' => 'any',
            ],
            '512x512' => [
                'path' => config('filesystems.disks.vortech.url').('pwa/icons/icon-512x512.png'),
                'purpose' => 'any',
            ],
        ],
        'splash' => [
            '640x1136' => config('filesystems.disks.vortech.url').('pwa/splash/splash-640x1136.png'),
            '750x1334' => config('filesystems.disks.vortech.url').('pwa/splash/splash-750x1334.png'),
            '828x1792' => config('filesystems.disks.vortech.url').('pwa/splash/splash-828x1792.png'),
            '1125x2436' => config('filesystems.disks.vortech.url').('pwa/splash/splash-1125x2436.png'),
            '1242x2208' => config('filesystems.disks.vortech.url').('pwa/splash/splash-1242x2208.png'),
            '1242x2688' => config('filesystems.disks.vortech.url').('pwa/splash/splash-1242x2688.png'),
            '1536x2048' => config('filesystems.disks.vortech.url').('pwa/splash/splash-1536x2048.png'),
            '1668x2224' => config('filesystems.disks.vortech.url').('pwa/splash/splash-1668x2224.png'),
            '1668x2388' => config('filesystems.disks.vortech.url').('pwa/splash/splash-1668x2388.png'),
            '2048x2732' => config('filesystems.disks.vortech.url').('pwa/splash/splash-2048x2732.png'),
        ],
        'custom' => [],
    ],
];
