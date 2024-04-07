<?php

namespace App\Livewire\Railway\Engine;

use Livewire\Component;

class EngineShowAction extends Component
{
    public $engine;
    public function render()
    {
        return view('livewire.railway.engine.engine-show-action');
    }
}
