<?php

namespace App\Actions;

class DeleteMedia
{
    public function handle(string $sector, int $model_id): bool
    {
        return match ($sector) {
            'events' => $this->deleteEventMedias($model_id),
        };
    }

    private function deleteEventMedias(int $model_id)
    {
        try {
            \Storage::deleteDirectory('events/'.$model_id);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
