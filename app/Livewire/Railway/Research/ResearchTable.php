<?php

namespace App\Livewire\Railway\Research;

use App\Actions\ErrorDispatchHandle;
use App\Models\Railway\Research\RailwayResearchCategory;
use App\Models\Railway\Research\RailwayResearches;
use Illuminate\Database\Eloquent\Builder;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ResearchTable extends Component
{
    use LivewireAlert, WithFileUploads, WithPagination;
    public RailwayResearchCategory $category;
    public ?string $type = null;

    //Search & Filter
    public string $search = '';
    public string $orderField = 'name';
    public string $orderDirection = 'asc';
    public int $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'orderField' => ['except' => 'name'],
        'orderDirection' => ['except' => 'ASC'],
    ];

    // Form


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

    public function delete(int $research_id)
    {
        try {
            RailwayResearches::find($research_id)->delete();
            $this->alert('success', 'La recherche à été supprimer');
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', 'Une erreur est survenue');
        }
    }

    public function render()
    {
        return view('livewire.railway.research.research-table', [
            'researches' => $this->category->railwayResearches()->with('parent', 'childrens')
                ->when($this->search, fn(Builder $query) => $query->where('name', 'like', "%{$this->search}%"))
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate($this->perPage),
        ]);
    }
}
