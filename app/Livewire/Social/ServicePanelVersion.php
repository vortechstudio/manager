<?php

namespace App\Livewire\Social;

use Livewire\Component;

class ServicePanelVersion extends Component
{
    public \App\Models\Config\Service $service;
    public function render()
    {
        return view('livewire.social.service-panel-version');
    }
}
