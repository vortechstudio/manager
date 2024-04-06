<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Intervention\Image\ImageManager;
use Symfony\Component\HttpFoundation\File\File;

class UploadImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public string $file, public string $type, public ?string $type_engine = null)
    {
    }

    public function handle(): void
    {
        match ($this->type) {
            'engine' => $this->uploadImageEngine($this->file),
        };
    }

    private function uploadImageEngine(string $file)
    {
        $f = new File($file);
        $manager = ImageManager::gd()->read($file);
        $manager->save();
    }
}
