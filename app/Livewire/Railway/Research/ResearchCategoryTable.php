<?php

namespace App\Livewire\Railway\Research;

use App\Actions\ErrorDispatchHandle;
use App\Models\Railway\Research\RailwayResearchCategory;
use App\Models\Railway\Research\RailwayResearches;
use App\Models\Railway\Research\RailwayResearchTrigger;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ResearchCategoryTable extends Component
{
    use LivewireAlert;

    public function delete(int $category_id)
    {
        try {
            $category = RailwayResearchCategory::find($category_id);

            foreach ($category->railwayResearches as $railwayResearch) {
                $railwayResearch->delete();
            }

            $category->delete();
            $this->alert('success', 'La Catégorie à été supprimé');
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', 'Une erreur à eu lieu');
        }
    }

    public function export()
    {
        $categories = RailwayResearchCategory::all()->toJson();
        $researches = RailwayResearches::all()->toJson();
        $triggers = RailwayResearchTrigger::all()->toJson();

        try {
            \Storage::put('data/research_categories.json', $categories);
            \Storage::put('data/researches.json', $researches);
            \Storage::put('data/research_triggers.json', $triggers);
            $this->alert('success', 'Export Effectuer !');
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', 'Une erreur à eu lieu !');
        }
    }

    public function import()
    {
        $categories = json_decode(\Storage::get('data/research_categories.json'), true);
        $researches = json_decode(\Storage::get('data/researches.json'), true);
        $triggers = json_decode(\Storage::get('data/research_triggers.json'), true);

        try {
            foreach ($categories as $category) {
                RailwayResearchCategory::updateOrCreate(['id' => $category['id']], [
                    'id' => $category['id'],
                    'name' => $category['name'],
                ]);
            }

            foreach ($researches as $research) {
                RailwayResearches::updateOrCreate(['id' => $research['id']], [
                    'id' => $research['id'],
                    'name' => $research['name'],
                    'description' => $research['description'],
                    'cost' => $research['cost'],
                    'level' => $research['level'],
                    'parent_id' => $research['parent_id'],
                    'level_description' => $research['level_description'],
                    'railway_research_category_id' => $research['railway_research_category_id'],
                ]);
            }

            foreach ($triggers as $trigger) {
                RailwayResearchTrigger::updateOrCreate(['id' => $trigger['id']], [
                    'id' => $trigger['id'],
                    'name' => $trigger['name'],
                    'action' => $trigger['action'],
                    'action_count' => $trigger['action_count'],
                    'railway_researches_id' => $trigger['railway_researches_id'],
                ]);
            }

            $this->alert('success', 'Import Effectuer !');
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', 'Une erreur à eu lieu !');
        }

    }

    public function render()
    {
        return view('livewire.railway.research.research-category-table', [
            'categories' => RailwayResearchCategory::with('railwayResearches')->get(),
        ]);
    }
}
