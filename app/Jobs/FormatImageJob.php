<?php

namespace App\Jobs;

use App\Services\Github\Issues;
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
        public ?string $nameFile = null,
    ) {
    }

    /**
     * @throws \Exception
     */
    public function handle(): void
    {
        $file = ImageManager::gd()->read($this->filePath);

        match ($this->sector) {
            'article' => $this->handleArticle($file, $this->directoryUpload),
            'event' => $this->handleEvent($file, $this->directoryUpload),
            'rental' => $this->handleRental($file, $this->directoryUpload),
            'banque' => $this->handleBanque($file, $this->directoryUpload),
            'cercle' => $this->handleCercle($file, $this->directoryUpload),
            'cercle_header' => $this->handleCercleHeader($file, $this->directoryUpload),
            'cercle_icon' => $this->handleCercleIcon($file, $this->directoryUpload),
        };
    }

    private function handleArticle(\Intervention\Image\Interfaces\ImageInterface $file, string $directoryUpload): void
    {
        $file->toWebp(60);
        $file->save($directoryUpload.'/default.webp');
    }

    private function handleEvent(\Intervention\Image\Interfaces\ImageInterface $file, string $directoryUpload): void
    {
        $file->toWebp(60);
        $file->save($directoryUpload.'/default.webp');
    }

    /**
     * @throws \Exception
     */
    private function handleRental(\Intervention\Image\Interfaces\ImageInterface $file, string $directoryUpload)
    {
        $file->toWebp(60);
        try {
            $file->save($directoryUpload.'/'.\Str::lower($this->nameFile).'.webp');
        } catch (\Exception $exception) {
            \Log::critical("Error: {$exception->getMessage()}", ['exception' => $exception]);
            $issue = new Issues(Issues::createIssueMonolog('article_image', $exception->getMessage(), [$exception]));
            $issue->createIssueFromException();
            throw new \Exception("Error saving image: {$exception->getMessage()}");
        }
    }

    /**
     * @throws \Exception
     */
    private function handleBanque(\Intervention\Image\Interfaces\ImageInterface $file, string $directoryUpload)
    {
        $file->toWebp(60);
        try {
            $file->save($directoryUpload.'/'.\Str::lower($this->nameFile).'.webp');
        } catch (\Exception $exception) {
            \Log::critical("Error: {$exception->getMessage()}", ['exception' => $exception]);
            $issue = new Issues(Issues::createIssueMonolog('article_banque', $exception->getMessage(), [$exception]));
            $issue->createIssueFromException();
            throw new \Exception("Error saving image: {$exception->getMessage()}");
        }
    }

    private function handleCercle(\Intervention\Image\Interfaces\ImageInterface $file, string $directoryUpload)
    {
        $file->toWebp(60);
        $file->save($directoryUpload.'/default.webp');
    }

    private function handleCercleHeader(\Intervention\Image\Interfaces\ImageInterface $file, string $directoryUpload)
    {
        $file->toWebp(60);
        $file->save($directoryUpload.'/header.webp');
    }

    private function handleCercleIcon(\Intervention\Image\Interfaces\ImageInterface $file, string $directoryUpload)
    {
        $file->toWebp(60);
        $file->save($directoryUpload.'/icon.webp');
    }
}
