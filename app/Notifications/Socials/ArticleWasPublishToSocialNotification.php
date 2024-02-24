<?php

namespace App\Notifications\Socials;

use App\Models\Social\Article;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\FacebookPoster\FacebookPosterChannel;
use NotificationChannels\FacebookPoster\FacebookPosterPost;
use NotificationChannels\OneSignal\OneSignalChannel;
use NotificationChannels\Twitter\TwitterChannel;

class ArticleWasPublishToSocialNotification extends Notification
{
    public function __construct(public Article $article)
    {
    }

    public function via($notifiable): array
    {
        return [FacebookPosterChannel::class];
    }

    public function toFacebookPoster($notifiable) {
        return (new FacebookPosterPost('Laravel notifications are awesome!'));
    }
}
