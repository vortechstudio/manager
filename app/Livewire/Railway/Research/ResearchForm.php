<?php

namespace App\Livewire\Railway\Research;

use App\Actions\ErrorDispatchHandle;
use App\Models\Railway\Research\RailwayResearchCategory;
use App\Models\Railway\Research\RailwayResearches;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class ResearchForm extends Component
{
    use LivewireAlert, WithFileUploads;
    public RailwayResearchCategory $category;
    public RailwayResearches $researches;

    // Form
    public string $name = '';
    public ?string $description = null;
    public int $level = 0;
    public int $cost = 0;
    public ?int $parent_id = null;

    public function mount()
    {
        if(isset($this->researches)) {
            $this->name = $this->researches->name;
            $this->description = $this->researches->description;
            $this->level = $this->researches->level;
            $this->cost = $this->researches->cost;
            $this->parent_id = $this->researches->parent_id;
        }
    }

    public function save()
    {
        try {
            RailwayResearches::create([
                'name' => $this->name,
                'description' => $this->description,
                'level' => $this->level,
                'cost' => $this->cost,
                'railway_research_category_id' => $this->category->id,
                'parent_id' => $this->parent_id,
            ]);
            $this->dispatch('closeModal', 'addResearch');
            $this->alert('success', 'La recherche à été ajouté !');
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', 'Une erreur est survenue');
        }
    }

    public function editing()
    {
        try {
            $this->researches->update([
                'name' => $this->name,
                'description' => $this->description,
                'level' => $this->level,
                'cost' => $this->cost,
                'railway_research_category_id' => $this->category->id,
                'parent_id' => $this->parent_id,
            ]);

            $this->dispatch('closeModal', 'addResearch');
            $this->alert('success', 'La recherche à été edité !');
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', 'Une erreur est survenue');
        }
    }

    public function render()
    {
        return view('livewire.railway.research.research-form');
    }
}
