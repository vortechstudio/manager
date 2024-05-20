<?php

namespace App\Livewire\Railway\Hubs;

use App\Models\Railway\Gare\RailwayGare;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class HubPanelInfo extends Component
{
    use LivewireAlert;

    public RailwayGare $gare;

    public function production(): void
    {
        try {
            $this->gare->hub->status = 'production';
            $this->gare->hub->save();

            $this->alert('success', 'Gare mise en production');
        } catch (\Exception $e) {
            $this->alert('error', 'Une erreur est survenue');
        }
    }

    public function disabled(): void
    {
        try {
            $this->gare->hub->active = false;
            $this->gare->hub->save();

            $this->alert('success', 'Gare désactivée');
        } catch (\Exception $e) {
            $this->alert('error', 'Une erreur est survenue');
        }
    }

    public function enabled(): void
    {
        try {
            $this->gare->hub->active = true;
            $this->gare->hub->save();

            $this->alert('success', 'Gare activée');
        } catch (\Exception $e) {
            $this->alert('error', 'Une erreur est survenue');
        }
    }

    public function delete()
    {
        try {
            $this->gare->delete();
            $this->alert('success', 'Gare supprimée');
        } catch (\Exception $e) {
            $this->alert('error', 'Une erreur est survenue');
        }

        return redirect()->route('railway.hubs.index');
    }

    public function render()
    {
        return view('livewire.railway.hubs.hub-panel-info');
    }
}
