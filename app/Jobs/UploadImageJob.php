<?php

namespace App\Jobs;

use App\Models\Railway\Config\RailwayRental;
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

    public function __construct(public $file, public string $type, public ?string $type_engine = null, public ?int $model = null)
    {
    }

    public function handle(): void
    {
        match ($this->type) {
            'engine' => $this->uploadImageEngine($this->file),
            'rental' => $this->uploadImageRental($this->file, $this->model),
        };
    }

    private function uploadImageEngine(string $file): void
    {
        $f = new File($file);
        $manager = ImageManager::gd()->read($file);
        $manager->save();
    }

    private function uploadImageRental(string $file, int $model): void
    {
        dd($file, $model);
        $rental = RailwayRental::find($model);
        $f = new File($file);
        dd($f);
        $manager = ImageManager::gd()->read($file);
        $manager->toWebp(60);
        $manager->save('logos/rentals/'.\Str::lower($rental->name).'.webp');
    }
}
