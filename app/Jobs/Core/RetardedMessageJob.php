<?php

namespace App\Jobs\Core;

use App\Actions\ErrorDispatchHandle;
use App\Models\Railway\Core\Message;
use App\Models\User\Railway\UserRailwayMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RetardedMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly Message $message, private readonly bool $allUser, private readonly ?Collection $listUsers)
    {
    }

    public function handle(): void
    {
        $users = $this->allUser ? $this->message->service->users : $this->listUsers->all();
        try {
            foreach ($users as $user) {
                UserRailwayMessage::create([
                    'user_id' => $user->id,
                    'message_id' => $this->message->id,
                ]);
            }
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
        }
    }
}
