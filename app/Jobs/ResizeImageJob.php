<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Intervention\Image\ImageManager;

class ResizeImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public string $filePath,
        public string $directoryUpload,
        public string $sector,
    ) {
    }

    public function handle(): void
    {
        $file = ImageManager::gd()->read($this->filePath);

        match ($this->sector) {
            'article' => $this->handleArticle($file, $this->directoryUpload),
            'event' => $this->handleEvent($file, $this->directoryUpload),
            'cercle' => $this->handleCercle($file, $this->directoryUpload),
        };
    }

    private function handleArticle(\Intervention\Image\Interfaces\ImageInterface $file, string $directoryUpload): void
    {
        $file->cover($file->width(), 320);
        $file->scale(1024);
        $file->toWebp(60);
        $file->save($directoryUpload.'/header.webp');
    }

    private function handleEvent(\Intervention\Image\Interfaces\ImageInterface $file, string $directoryUpload): void
    {
        $file->cover($file->width(), 320);
        $file->scale(1024);
        $file->toWebp(60);
        $file->save($directoryUpload.'/header.webp');

        $file->cover($file->width(), 96);
        $file->scale(96);
        $file->toWebp(60);
        $file->save($directoryUpload.'/icon.webp');
    }

    private function handleCercle(\Intervention\Image\Interfaces\ImageInterface $file, string $directoryUpload): void
    {
        $file->cover($file->width(), 320);
        $file->scale(1024);
        $file->toWebp(60);
        $file->save($directoryUpload.'/header.webp');

        $file->cover($file->width(), 96);
        $file->scale(96);
        $file->toWebp(60);
        $file->save($directoryUpload.'/icon.webp');
    }
}
