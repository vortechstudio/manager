<?php

namespace App\Livewire\Railway\Ligne;

use App\Actions\Railway\LigneAction;
use App\Models\Railway\Ligne\RailwayLigne;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class LignePanelInfo extends Component
{
    use LivewireAlert;

    public RailwayLigne $ligne;

    public function disabled(): void
    {
        try {
            $this->ligne->active = false;
            $this->ligne->save();

            $this->alert('success', 'La ligne a bien été désactivée');
        } catch (\Exception $exception) {
            $this->alert('error', 'Erreur lors de la désactivation de la ligne');
        }
    }

    public function enabled(): void
    {
        try {
            $this->ligne->active = true;
            $this->ligne->save();

            $this->alert('success', 'La ligne a bien été activée');
        } catch (\Exception $exception) {
            $this->alert('error', 'Erreur lors de l\'activation de la ligne');
        }
    }

    public function production(): void
    {
        try {
            $this->ligne->status = 'production';
            $this->ligne->save();

            $this->alert('success', 'La ligne a bien été en production');
        } catch (\Exception $exception) {
            $this->alert('error', 'Erreur lors de la modification de la ligne');
        }
    }

    public function delete(): void
    {
        try {
            $this->ligne->delete();

            $this->alert('success', 'La ligne a bien été supprimée');
        } catch (\Exception $exception) {
            $this->alert('error', 'Erreur lors de la suppression de la ligne');
        }
    }

    public function distance(): void
    {
        try {
            $sum = $this->ligne->stations()->sum('distance');

            $this->ligne->distance = $sum;
            $this->ligne->save();
            $this->ligne->refresh();

            $this->alert('success', 'La distance a bien été mise à jour');
        } catch (\Exception $exception) {
            $this->alert('error', 'Erreur lors de la mise à jour de la distance');
        }
    }

    public function pricing(): void
    {
        try {
            if ($this->ligne->distance == 0) {
                $this->alert('warning', $this->ligne->name, [
                    'text' => 'Veuillez effectuer le calcule de distance avant !',
                ]);
            } else {
                $this->ligne->update([
                    'price' => (new LigneAction())->calculatePrice($this->ligne),
                ]);

                $this->alert('success', $this->ligne->name, [
                    'text' => 'Le prix de la ligne à bien été calculer',
                ]);
            }
        } catch (\Exception $exception) {
            $this->alert('error', 'Erreur lors du calcul du prix de la ligne');
        }
    }

    public function render()
    {
        return view('livewire.railway.ligne.ligne-panel-info');
    }
}
