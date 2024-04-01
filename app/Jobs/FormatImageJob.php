<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Intervention\Image\ImageManager;

class FormatImageJob implements ShouldQueue
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
        };
    }

    private function handleArticle(\Intervention\Image\Interfaces\ImageInterface $file, string $directoryUpload): void
    {
        $file->toWebp(60);
        $file->save($directoryUpload.'/default.webp');
    }

    private function handleEvent(\Intervention\Image\Interfaces\ImageInterface $file, string $directoryUpload)
    {
        $file->toWebp(60);
        $file->save($directoryUpload.'/default.webp');
    }
}
