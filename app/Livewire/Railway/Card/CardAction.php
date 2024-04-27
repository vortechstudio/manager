<?php

namespace App\Livewire\Railway\Card;

use App\Actions\Railway\AdvantageCardAction;
use App\Models\Railway\Config\RailwayAdvantageCard;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CardAction extends Component
{
    use LivewireAlert;

    public string $class;

    public string $type;

    public int|float $qte;

    public int|float $tpoint;

    public int $model_id;

    public function save()
    {
        try {
            RailwayAdvantageCard::create([
                'class' => $this->class,
                'type' => $this->type,
                'description' => (new AdvantageCardAction())->defineDescriptionFromType($this->type, $this->qte),
                'qte' => $this->qte,
                'tpoint' => $this->tpoint,
                'drop_rate' => (new AdvantageCardAction())->calculateDropRateByType($this->qte, $this->type),
                'model_id' => $this->model_id,
            ]);

            $this->alert('success', 'Carte ajoutée avec succès');
            $this->dispatch('closeModal', 'addCard');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function refresh()
    {
        try {
            (new AdvantageCardAction())->generate();
            $this->alert('success', 'Cartes mises à jour avec succès');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.railway.card.card-action');
    }
}
