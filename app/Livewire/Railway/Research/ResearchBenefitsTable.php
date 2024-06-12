<?php

namespace App\Livewire\Railway\Research;

use App\Actions\ErrorDispatchHandle;
use App\Models\Railway\Research\RailwayResearches;
use App\Models\Railway\Research\RailwayResearchTrigger;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class ResearchBenefitsTable extends Component
{
    use LivewireAlert, WithPagination;
    public RailwayResearches $researches;

    //filter
    public string $search = '';
    public string $orderField = 'name';
    public string $orderDirection = 'asc';
    public int $perPage = 10;

    //form
    public string $name = '';
    public string $action = '';
    public int|float $action_count = 0;

    protected $queryString = [
        'search' => ['except' => ''],
        'orderField' => ['except' => 'name'],
        'orderDirection' => ['except' => 'ASC'],
    ];

    public function setOrderField(string $name): void
    {
        if ($name === $this->orderField) {
            $this->orderDirection = $this->orderDirection === 'ASC' ? 'DESC' : 'ASC';
        } else {
            $this->orderField = $name;
            $this->reset('orderDirection');
        }
    }

    public function paginationView()
    {
        return 'livewire.pagination';
    }

    public function save()
    {
        try {
            RailwayResearchTrigger::create([
                'name' => $this->name,
                'action' => $this->action,
                'action_count' => $this->action_count,
                'railway_researches_id' => $this->researches->id
            ]);

            $this->alert('success', 'Bénéfice ajouter avec succès');
            $this->alert('info', "Pensez à créer la classe du déclencheur dans le dossier App/Railway/ResearchTrigger/class", [
                'toast' => false,
                'position' => 'center',
            ]);
            $this->dispatch('closeModal', 'addBenefit');
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', 'Une erreur est survenue');
        }
    }

    public function delete(int $trigger_id)
    {
        try {
            RailwayResearchTrigger::find($trigger_id)->delete();
            $this->alert('success', 'Le déclencheur à été supprimer');
            $this->alert('info', 'Pensez-à supprimer la classe du déclencheur `App/Railway/ResearchTrigger/class`');
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', 'Une erreur à eu lieu');
        }
    }

    public function render()
    {
        //dd($this->benefits);
        return view('livewire.railway.research.research-benefits-table', [
            'benefits' => RailwayResearchTrigger::where('railway_researches_id', $this->researches->id)
                ->when($this->search, fn (Builder $query) => $query->where('name', 'like', '%' . $this->search . '%'))
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate($this->perPage),
        ]);
    }
}
