<?php

namespace App\Notifications\Socials;

use App\Models\Social\Article;
use App\Services\Github\Issues;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twitter\Exceptions\CouldNotSendNotification;
use NotificationChannels\Twitter\TwitterChannel;
use NotificationChannels\Twitter\TwitterStatusUpdate;

class ArticleWasPublishToSocialNotification extends Notification
{
    public function __construct(public Article $article)
    {
    }

    public function via($notifiable): array
    {
        return [TwitterChannel::class, 'database'];
    }

    public function toTwitter($notifiable)
    {
        try {
            return (new TwitterStatusUpdate($this->article->title))
                ->withImage(\Storage::disk('vortech')->url('blog/'.$this->article->id.'/default.png'));
        } catch (CouldNotSendNotification $e) {
            \Log::error($e->getMessage(), [$e]);
            $issue = Issues::createIssueMonolog('article publish to twitter', $e->getMessage(), [$e]);
            (new Issues($issue))->createIssueFromException();

            return null;
        }
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type' => 'info',
            'icon' => 'fas fa-newspaper',
            'title' => $this->article->title,
            'description' => $this->article->description,
            'time' => now(),
            'sector' => 'news',
        ];
    }
}
