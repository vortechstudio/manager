<?php

namespace App\Actions;

use App\Models\User\User;
use App\Notifications\Users\SendMessageNotification;

class UserAction
{
    public function sendNotificationToAdmin(string $title, string $message, string $type = 'info')
    {
        foreach (User::where('admin', true)->get() as $user) {
            $user->notify(new SendMessageNotification(
                title: $title,
                sector: 'alerts',
                type: $type,
                message: $message,
            ));
        }
    }
}
