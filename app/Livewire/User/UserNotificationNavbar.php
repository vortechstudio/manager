<?php

namespace App\Livewire\User;

use App\Models\User\User;
use Livewire\Component;

class UserNotificationNavbar extends Component
{
    public User $user;

    public function mount(User $user): void
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.user.user-notification-navbar');
    }
}
