<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

class Dashboard extends Component
{
    #[Title("Tableau de Bord")]
    public function render()
    {
        return view('livewire.dashboard')
            ->layout('layouts.app');
    }
}
