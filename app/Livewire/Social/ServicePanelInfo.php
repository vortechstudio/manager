<?php

namespace App\Livewire\Social;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ServicePanelInfo extends Component
{
    use LivewireAlert;

    public \App\Models\Config\Service $service;

    public function render()
    {
        return view('livewire.social.service-panel-info');
    }
}
