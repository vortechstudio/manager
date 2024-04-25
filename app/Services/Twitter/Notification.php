<?php

namespace App\Services\Twitter;

use Atymic\Twitter\Facade\Twitter;

class Notification
{
    public function send(string $text, ?string $pathMedia = null): void
    {
        if ($pathMedia != null) {
            try {
                $uploadedMedia = Twitter::uploadMedia(['media' => $pathMedia]);
                Twitter::postTweet([
                    'status' => $text,
                    'media_ids' => $uploadedMedia->media_id_string,
                    'response_format' => 'json',
                ]);
            } catch (\Exception $e) {
                \Log::error($e->getMessage(), [$e]);
            }
        } else {
            try {
                Twitter::postTweet(['status' => $text, 'response_format' => 'json']);
            } catch (\Exception $exception) {
                \Log::error($exception->getMessage(), [$exception]);
            }
        }
    }
}
