<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\Controller;
use App\Models\Railway\Core\Message;

class MessagerieController extends Controller
{
    public function index()
    {
        return view('social.messagerie.index');
    }

    public function show(int $message_id)
    {
        $message = Message::with('railway_messages')->find($message_id);
        return view('social.messagerie.show', [
            'message' => $message,
        ]);
    }
}
