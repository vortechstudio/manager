<?php

namespace App\Livewire\Social;

use Livewire\Component;

class ServicePanelContent extends Component
{
    public \App\Models\Config\Service $service;

    public function render()
    {
        return view('livewire.social.service-panel-content');
    }
}
