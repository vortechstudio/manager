<?php

namespace App\Actions;

use App\Models\User\User;
use App\Notifications\Users\SendMessageNotification;

class UserAction
{
    public function sendNotificationToAdmin(string $title, string $message, string $type = 'info'): void
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

    public function sendNotificationToUsers(string $title, string $message, string $type = 'info'): void
    {
        foreach (User::all() as $user) {
            if ($user->profil->notification) {
                $user->notify(new SendMessageNotification(
                    title: $title,
                    sector: 'alerts',
                    type: $type,
                    message: $message,
                ));
            }
        }
    }
}
