<?php

namespace App\Livewire\Railway\Engine;

use App\Models\Railway\Engine\RailwayEngine;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class EngineShowAction extends Component
{
    use LivewireAlert;

    public RailwayEngine $engine;

    public function disabled()
    {
        $this->engine->active = false;
        $this->engine->save();

        $this->alert('success', 'Le matériel est maintenant inactif');
    }

    public function enabled()
    {
        $this->engine->active = true;
        $this->engine->save();

        $this->alert('success', 'Le matériel est maintenant actif');
    }

    public function production()
    {
        $this->engine->visual = 'production';
        $this->engine->save();

        $this->alert('success', 'Le matériel est maintenant en production');
    }

    public function delete()
    {
        if ($this->engine->type_train->value == 'automotrice') {
            for ($i = 0; $i <= $this->engine->technical->nb_wagon; $i++) {
                \Storage::delete('engines/automotrice/'.$this->engine->slug.'-'.$i.'.gif');
            }
        } else {
            \Storage::delete('engines/'.$this->engine->type_train->value.'/'.$this->engine->slug.'.gif');
        }

        $this->engine->delete();

        $this->alert('success', 'Le matériel est maintenant supprimé');
    }

    public function render()
    {
        return view('livewire.railway.engine.engine-show-action');
    }
}
