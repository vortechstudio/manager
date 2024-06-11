<?php

namespace App\Livewire\Railway\Research;

use App\Actions\ErrorDispatchHandle;
use App\Models\Railway\Research\RailwayResearchCategory;
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
            $this->alert('success', "La Catégorie à été supprimé");
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', 'Une erreur à eu lieu');
        }
    }
    public function render()
    {
        return view('livewire.railway.research.research-category-table', [
            'categories' => RailwayResearchCategory::with('railwayResearches')->get(),
        ]);
    }
}
