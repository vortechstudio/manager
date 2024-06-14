<?php

namespace App\Livewire\Railway\Research;

use App\Actions\ErrorDispatchHandle;
use App\Models\Railway\Research\RailwayResearchCategory;
use App\Models\Railway\Research\RailwayResearches;
use App\Models\User\Railway\UserRailway;
use App\Models\User\ResearchUser;
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

    public int $time_base = 0;

    public ?int $parent_id = null;

    public function mount()
    {
        if (isset($this->researches)) {
            $this->name = $this->researches->name;
            $this->description = $this->researches->description;
            $this->level = $this->researches->level;
            $this->cost = $this->researches->cost;
            $this->parent_id = $this->researches->parent_id;
            $this->time_base = $this->researches->time_base;
        }
    }

    public function save()
    {
        try {
            $research = RailwayResearches::create([
                'name' => $this->name,
                'description' => $this->description,
                'level' => $this->level,
                'cost' => $this->cost,
                'railway_research_category_id' => $this->category->id,
                'parent_id' => $this->parent_id,
                'time_base' => $this->time_base,
            ]);

            foreach (UserRailway::all() as $user) {
                ResearchUser::create([
                    'user_railway_id' => $user->id,
                    'railway_research_id' => $research->id,
                    'current_level' => 0,
                    'is_unlocked' => ! $research->parent_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

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
                'time_base' => $this->time_base,
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
