<?php

namespace App\Livewire\Railway\Ligne;

use App\Models\Railway\Ligne\RailwayLigne;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class LignePanelInfo extends Component
{
    use LivewireAlert;

    public RailwayLigne $ligne;

    public function disabled()
    {
        try {
            $this->ligne->active = false;
            $this->ligne->save();

            $this->alert('success', 'La ligne a bien été désactivée');
        } catch (\Exception $exception) {
            $this->alert('error', 'Erreur lors de la désactivation de la ligne');
        }
    }

    public function enabled()
    {
        try {
            $this->ligne->active = true;
            $this->ligne->save();

            $this->alert('success', 'La ligne a bien été activée');
        }catch (\Exception $exception) {
            $this->alert('error', 'Erreur lors de l\'activation de la ligne');
        }
    }

    public function production()
    {
        try {
            $this->ligne->status = 'production';
            $this->ligne->save();

            $this->alert('success', 'La ligne a bien été en production');
        }catch (\Exception $exception) {
            $this->alert('error', 'Erreur lors de la modification de la ligne');
        }
    }

    public function delete()
    {
        try {
            $this->ligne->delete();

            $this->alert('success', 'La ligne a bien été supprimée');
        }catch (\Exception $exception) {
            $this->alert('error', 'Erreur lors de la suppression de la ligne');
        }
    }

    public function render()
    {
        return view('livewire.railway.ligne.ligne-panel-info');
    }
}
