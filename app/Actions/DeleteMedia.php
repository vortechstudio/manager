<?php

namespace App\Actions;

use App\Models\Social\Post\Post;

class DeleteMedia
{
    public function handle(string $sector, int $model_id): bool
    {
        return match ($sector) {
            'events' => $this->deleteEventMedias($model_id),
            'posts' => $this->deletePostMedias($model_id),
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

    private function deletePostMedias(int $model_id)
    {
        try {
            $post = Post::find($model_id);
            foreach ($post->images as $image) {
                \Storage::delete($image->path);
                $image->delete();
            }

            return true;
        } catch (\Exception $e) {

            return false;
        }
    }
}
