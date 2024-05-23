<?php

namespace App\Livewire\Social\Menu;

use App\Models\Config\Menu;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class MenuTable extends Component
{
    use LivewireAlert, WithPagination;

    public string $orderField = 'section';

    public string $orderDirection = 'ASC';

    public string $search = '';

    public int $perPage = 5;

    public string $title = '';

    public string $sector = '';

    public string $icon = '';

    public string $url = '';

    public int $parent_id = 0;

    protected $queryString = [
        'search' => ['except' => ''],
        'orderField' => ['except' => 'section'],
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

    public function resetForm(): void
    {
        $this->title = '';
        $this->sector = '';
        $this->icon = '';
        $this->url = '';
        $this->parent_id = 0;
    }

    public function save(): void
    {
        try {
            Menu::set(
                section: $this->sector,
                title: $this->title,
                url: $this->url,
                icon: $this->icon,
                parent: $this->parent_id != 0 ? $this->parent_id : 0,
            );

            $this->alert('success', 'Menu ajouter avec succès');
            $this->dispatch('closeModal', 'addMenu');
        } catch (\Exception $exception) {
            \Log::emergency($exception->getMessage(), [$exception]);
            $this->alert('error', 'Erreur lors de la création du menu');
        }
    }

    public function render()
    {
        return view('livewire.social.menu.menu-table', [
            'menus' => Menu::with('translations', 'children', 'parent')
                ->when($this->search, fn ($query) => $query->where('section', 'like', '%'.$this->search.'%'))
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate($this->perPage),
        ]);
    }
}
