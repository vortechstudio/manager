<?php

namespace App\Livewire\Railway\Research;

use App\Actions\ErrorDispatchHandle;
use App\Models\Railway\Research\RailwayResearchCategory;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ResearchCategoryForm extends Component
{
    use LivewireAlert;
    public RailwayResearchCategory $category;

    public string $name = '';

    public function mount()
    {
        if(isset($this->category)) {
            $this->name = $this->category->name;
        } else {
            $this->name = '';
        }
    }

    public function save()
    {
        try {
            RailwayResearchCategory::create([
                'name' => $this->name
            ]);

            $this->dispatch('closeModal', 'addCategory')->self();
            $this->alert('success', 'La catégorie à été ajouté avec succès');
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', 'Une erreur à eu lieu');
        }
    }

    public function editing()
    {
        try {
            $this->category->update([
                'name' => $this->name
            ]);

            $this->dispatch('closeModal', 'addCategory')->self();
            $this->alert('success', 'La catégorie à été ajouté avec succès');
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', 'Une erreur à eu lieu');
        }
    }

    public function render()
    {
        return view('livewire.railway.research.research-category-form');
    }
}
