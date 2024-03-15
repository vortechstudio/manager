<?php

namespace App\Livewire\Social;

use Livewire\Attributes\Title;
use Livewire\Component;

class Dashboard extends Component
{
    #[Title('Tableau de Bord Social')]
    public function render()
    {
        return view('livewire.social.dashboard')
            ->layout('layouts.app');
    }
}
