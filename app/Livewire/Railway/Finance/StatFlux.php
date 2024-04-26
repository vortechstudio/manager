<?php

namespace App\Livewire\Railway\Finance;

use App\Models\Railway\Config\RailwayBanque;
use Livewire\Component;

class StatFlux extends Component
{
    public RailwayBanque $banque;

    public array $labels = [];

    public array $data = [];

    public function mount()
    {
        for ($i = 0; $i < 30; $i++) {
            $this->labels[] = date('Y-m-d', strtotime('-'.$i.' day'));
        }

        for ($i = 0; $i < 30; $i++) {
            $flux = $this->banque->fluxes()->whereDate('date', date('Y-m-d', strtotime('-'.$i.' day')))->first();
            $this->data[] = $flux ? floatval($flux->interest) : 0;
        }
    }

    public function render()
    {
        return view('livewire.railway.finance.stat-flux');
    }
}
