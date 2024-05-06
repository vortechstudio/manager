<?php

namespace App\Actions;

use App\Models\Social\Post\Post;

class DeleteMedia
{
    /**
     * Handle the given sector and model ID.
     *
     * @param  string  $sector  The sector to handle (events or posts)
     * @param  int  $model_id  The model ID to be deleted
     * @return bool Returns true if the sector was handled successfully, false otherwise
     */
    public function handle(string $sector, int $model_id): bool
    {
        return match ($sector) {
            'events' => $this->deleteEventMedias($model_id),
            'posts' => $this->deletePostMedias($model_id),
        };
    }

    /**
     * Delete the event medias for the given model ID.
     *
     * @param  int  $model_id  The model ID for which to delete event medias
     * @return bool Returns true if the event medias were deleted successfully, false otherwise
     */
    private function deleteEventMedias(int $model_id)
    {
        try {
            \Storage::deleteDirectory('events/'.$model_id);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Delete post medias
     *
     * @param  int  $model_id  The ID of the post model
     * @return bool Returns true if post medias are deleted successfully, false otherwise
     */
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
