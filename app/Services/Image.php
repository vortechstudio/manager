<?php

namespace App\Services;

use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Symfony\Component\HttpFoundation\File\File;

class Image
{
    public function __construct(public string $file, public string $directoryUpload, public string $nameUpload)
    {
    }

    public function resize(array $dimensions)
    {
        $file = new File($this->file);
        $manager = new ImageManager(Driver::class);
        foreach ($dimensions as $dimension) {
            $sys = $manager->read($file->getRealPath());
            $sys->resize($dimension, $dimension);
            $sys->toWebp(60);
            $sys->save($this->directoryUpload.'/'.$this->nameUpload);
        }
    }
}
